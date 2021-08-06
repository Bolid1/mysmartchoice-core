<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\FirmResource;
use App\Http\Resources\UserResource;
use App\Models\Firm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use function inertia;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the users.
     *
     * @return Response
     */
    public function index(Firm $firm): Response
    {
        Gate::authorize('view-users', $firm);

        FirmResource::withoutWrapping();

        return inertia('Users', [
            'firm' => FirmResource::make($firm),
            'users' => UserResource::collection(
                $firm->users()->select([$firm->users()->qualifyColumn('*')])->paginate(null, [])
            ),
        ]);
    }

    /**
     * Display the form for edit specified user.
     *
     * @param User $user
     */
    public function edit(User $user): Response
    {
        UserResource::withoutWrapping();

        return inertia('UserEdit', [
            'user' => UserResource::make($user),
        ]);
    }

    /**
     * Display the form for edit specified user.
     *
     * @param User $user
     */
    public function update(Request $request, User $user)
    {
        $user->update(
            $request->validate([
                'name' => 'required|string|max:255',
            ])
        );

        return Redirect::route('users.edit', $user, 303);
    }
}
