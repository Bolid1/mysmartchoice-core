<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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

        return inertia('Users', [
            'firm' => $firm,
            'users' => $firm->users()->select(['*'])->paginate(null, []),
        ]);
    }

    /**
     * Display the form for edit specified user.
     *
     * @param User $user
     */
    public function edit(User $user): Response
    {
        return inertia('UserEdit', [
            'user' => $user,
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
