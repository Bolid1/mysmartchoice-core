<?php

namespace App\Http\Controllers;

use App\Http\Resources\FirmResource;
use App\Models\Firm;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\Pure;

class FirmsController extends Controller
{
    /**
     * Display a listing of the firms.
     *
     * @return AnonymousResourceCollection
     */
    #[Pure] public function index(): AnonymousResourceCollection
    {
        return FirmResource::collection(
            Firm::all()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Firm  $firm
     * @return JsonResource
     */
    #[Pure] public function show(Firm $firm): JsonResource
    {
        return new FirmResource($firm);
    }
}
