<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FirmResource;
use App\Models\Firm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\Pure;

class FirmsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Firm::class);
    }

    /**
     * Display a listing of the firms.
     *
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    #[Pure]
    public function index(Request $request): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = $request->user();

        return FirmResource::collection(
            $user->firms()->paginate()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Firm $firm
     *
     * @return JsonResource
     */
    #[Pure]
    public function show(Firm $firm): JsonResource
    {
        return new FirmResource($firm);
    }
}
