<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Response;
use JetBrains\PhpStorm\Pure;
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
     * @param Request $request
     *
     * @return Response
     */
    #[Pure]
    public function index(Request $request): Response
    {
        /** @var User $user */
        $user = $request->user();

        return inertia('Users', [
            'users' => $user->comrades()->paginate(null, []),
        ]);
    }
}
