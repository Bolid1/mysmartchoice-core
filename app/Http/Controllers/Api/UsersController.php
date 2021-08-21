<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Firm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the users.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Firm $firm): AnonymousResourceCollection
    {
        Gate::authorize('view-users', $firm);

        return UserResource::collection(
            $firm->users()->select(['*'])->paginate(null, [])
        );
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     *
     * @return JsonResource
     */
    public function show(User $user): JsonResource
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     *
     * @return JsonResource
     */
    public function update(Request $request, User $user): JsonResource
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user->fill($validated)->save()
        ;

        return new UserResource($user);
    }
}