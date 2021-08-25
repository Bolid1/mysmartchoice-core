<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFirmRequest;
use App\Http\Requests\UpdateFirmRequest;
use App\Http\Resources\FirmResource;
use App\Models\Firm;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use function inertia;

class FirmsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Firm::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        /** @var User $user */
        $user = $request->user();

        return inertia('Firms', [
            'firms' => FirmResource::collection($user->firms),
            'can' => [
                'add' => $user->can('create', Firm::class),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        FirmResource::withoutWrapping();

        return inertia('FirmEdit', [
            'firm' => FirmResource::make(Firm::make([
                // todo: place default values here
            ])),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreFirmRequest $request
     *
     * @return RedirectResponse
     */
    public function store(StoreFirmRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $firm = $user->firms()->create($request->validated());

        return Redirect::route('firms.edit', ['firm' => $firm], 303);
    }

    /**
     * Display the specified resource.
     *
     * @param  Firm  $firm
     *
     * @return Response
     */
    public function show(Firm $firm): Response
    {
        $firm->loadMissing(
            'users',
            'accounts',
            'integrationsInstalls',
        );

        FirmResource::withoutWrapping();

        $firm->integrationsInstalls->loadMissing('integration', 'firm');

        return inertia('Firm', [
            'firm' => FirmResource::make($firm),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Firm  $firm
     *
     * @return Response
     */
    public function edit(Firm $firm): Response
    {
        FirmResource::withoutWrapping();

        return inertia('FirmEdit', [
            'firm' => FirmResource::make($firm),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateFirmRequest $request
     * @param  Firm  $firm
     *
     * @return RedirectResponse
     */
    public function update(UpdateFirmRequest $request, Firm $firm): RedirectResponse
    {
        $firm->update($request->validated());

        return Redirect::route('firms.edit', ['firm' => $firm], 303);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Firm  $firm
     *
     * @return RedirectResponse
     */
    public function destroy(Firm $firm): RedirectResponse
    {
        $firm->delete();

        return Redirect::route('firms.index', [], 303);
    }
}
