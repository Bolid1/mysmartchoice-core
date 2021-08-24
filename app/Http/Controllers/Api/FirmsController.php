<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFirmRequest;
use App\Http\Requests\UpdateFirmRequest;
use App\Http\Resources\FirmResource;
use App\Models\Firm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use function abort_if;

class FirmsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Firm::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = $request->user();

        return FirmResource::collection($user->firms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFirmRequest $request
     * @return JsonResource
     */
    public function store(StoreFirmRequest $request): JsonResource
    {
        /** @var User $user */
        $user = $request->user();

        $firm = $user->firms()->create($request->validated());

        return FirmResource::make($firm);
    }

    /**
     * Display the specified resource.
     *
     * @param  Firm $firm
     * @return JsonResource
     */
    public function show(Firm $firm): JsonResource
    {
        return FirmResource::make($firm);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateFirmRequest $request
     * @param  Firm $firm
     * @return JsonResource
     */
    public function update(UpdateFirmRequest $request, Firm $firm): JsonResource
    {
        abort_if(!$firm->update($request->validated()), 503);

        return FirmResource::make($firm);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Firm $firm
     * @return JsonResource
     */
    public function destroy(Firm $firm): JsonResource
    {
        abort_if(!$firm->delete(), 503);

        return FirmResource::make($firm);
    }
}
