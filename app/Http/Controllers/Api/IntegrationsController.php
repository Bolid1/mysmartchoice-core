<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIntegrationRequest;
use App\Http\Requests\UpdateIntegrationRequest;
use App\Http\Resources\IntegrationResource;
use App\Models\Integration;
use App\Models\User;
use App\Repositories\IntegrationsRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class IntegrationsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Integration::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request, IntegrationsRepository $repository): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = $request->user();

        return IntegrationResource::collection(
            $repository->getAvailableFor($user->id)->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreIntegrationRequest $request
     *
     * @return JsonResource
     */
    public function store(StoreIntegrationRequest $request): JsonResource
    {
        /** @var User $user */
        $user = $request->user();

        return IntegrationResource::make(
            Integration::create(
                ['owner_id' => $user->id] + $request->validated()
            )
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Integration $integration
     *
     * @return JsonResource
     */
    public function show(Integration $integration): JsonResource
    {
        return IntegrationResource::make($integration);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateIntegrationRequest  $request
     * @param Integration  $integration
     *
     * @return JsonResource
     */
    public function update(UpdateIntegrationRequest $request, Integration $integration): JsonResource
    {
        $integration->update(
            $request->validated()
        );

        return IntegrationResource::make($integration);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Integration  $integration
     *
     * @return JsonResource
     */
    public function destroy(Integration $integration): JsonResource
    {
        $integration->delete();

        return IntegrationResource::make($integration);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function uploadJS(Request $request, Integration $integration): array
    {
        $request->validate([
            'file' => 'required|file|max:1024|mimetypes:application/javascript,text/plain',
        ]);

        /** @var UploadedFile $file */
        $file = $request->file('file');
        $stored = $file->storeAs(
            'integrations',
            "{$integration->id}.js",
            'public',
        );

        $integration->javascript_file = Storage::url($stored);

        $integration->save();

        return ['url' => $integration->javascript_file];
    }
}
