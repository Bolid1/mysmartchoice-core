<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Firm;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use function inertia;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class.',firm', 'user,firm');
    }

    /**
     * Display a listing of the users.
     *
     * @param Firm $firm
     *
     * @return Response
     */
    public function index(Firm $firm): Response
    {
        return inertia('Firms/Users', [
            'firm' => $firm,
            /* @uses \App\Models\User::beforeSerializationToResponse */
            'users' => $firm->users->map->beforeSerializationToResponse(),
        ]);
    }

    /**
     * Display the form for edit specified user.
     *
     * @param Firm $firm
     * @param User $user
     *
     * @return Response
     */
    public function edit(Firm $firm, User $user): Response
    {
        return inertia('Firms/UserEdit', [
            'firm' => $firm,
            'user' => $user->beforeSerializationToResponse(),
        ]);
    }

    /**
     * Display the form for edit specified user.
     *
     * @param Request $request
     * @param Firm $firm
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Firm $firm, User $user): RedirectResponse
    {
        $user->update(
            $request->validate([
                'name' => 'required|string|max:255',
            ])
        );

        return Redirect::route(
            'firms.users.edit',
            [
                'firm' => $firm,
                'user' => $user->beforeSerializationToResponse(),
            ],
            303
        );
    }
}
