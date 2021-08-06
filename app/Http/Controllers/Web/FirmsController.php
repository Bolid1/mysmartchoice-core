<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\FirmResource;
use App\Models\Firm;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Response;
use function inertia;

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
     */
    public function index(Request $request): Response
    {
        /** @var User $user */
        $user = $request->user();

        return inertia('Dashboard', [
            'firms' => FirmResource::collection($user->firms()->paginate()),
        ]);
    }

    public function show(Firm $firm): Response
    {
        $firm->load('users');

        FirmResource::withoutWrapping();

        return inertia('Firm', [
            'firm' => FirmResource::make($firm),
        ]);
    }
}
