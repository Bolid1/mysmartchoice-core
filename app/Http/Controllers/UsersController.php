<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\Pure;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the users.
     *
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    #[Pure] public function index(Request $request): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = $request->user();

        return UserResource::collection(
            $user->comrades()->paginate(null, [])
        );
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResource
     */
    #[Pure] public function show(User $user): JsonResource
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return JsonResource
     */
    public function update(Request $request, User $user): JsonResource
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user->fill($validated)->save();

        return new UserResource($user);
    }
}
