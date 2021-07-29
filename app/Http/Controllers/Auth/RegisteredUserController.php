<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Managers\UsersManager;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Validators\UserValidator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use function abort_if;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @param UserValidator $validator
     * @param UsersManager $manager
     *
     * @return RedirectResponse
     */
    public function store(
        Request $request,
        UserValidator $validator,
        UsersManager $manager
    ): RedirectResponse
    {
        $user = $manager->register(
            $request->validate($validator->getRulesForCreate())
        );

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
