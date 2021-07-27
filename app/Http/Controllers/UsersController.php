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
    /**
     * Display a listing of the users.
     *
     * @return AnonymousResourceCollection
     */
    #[Pure] public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::all());
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
