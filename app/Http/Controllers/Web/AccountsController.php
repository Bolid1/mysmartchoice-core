<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Enums\Currencies;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Resources\AccountResource;
use App\Http\Resources\FirmResource;
use App\Models\Account;
use App\Models\Firm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use function compact;
use function inertia;

class AccountsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Account::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Firm $firm
     *
     * @return Response
     */
    public function index(Firm $firm): Response
    {
        FirmResource::withoutWrapping();

        return inertia('Accounts', [
            'firm' => FirmResource::make($firm),
            'accounts' => AccountResource::collection($firm->accounts()->paginate()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Firm $firm
     *
     * @return Response
     */
    public function create(Firm $firm, Currencies $currencies): Response
    {
        FirmResource::withoutWrapping();
        AccountResource::withoutWrapping();

        return inertia('AccountEdit', [
            'firm' => FirmResource::make($firm),
            'account' => AccountResource::make(Account::make([
                'firm_id' => $firm->id,
            ])),
            'currencies' => $currencies->all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Firm $firm
     *
     * @return RedirectResponse
     */
    public function store(StoreAccountRequest $request, Firm $firm): RedirectResponse
    {
        $account = Account::create(
            ['firm_id' => $firm->id] + $request->validated()
        );

        return Redirect::route('firms.accounts.edit', compact('firm', 'account'), 303);
    }

    /**
     * Display the specified resource.
     *
     * @param Firm $firm
     * @param Account $account
     *
     * @return Response
     */
    public function show(Firm $firm, Account $account): Response
    {
        FirmResource::withoutWrapping();
        AccountResource::withoutWrapping();

        return inertia('Account', [
            'firm' => FirmResource::make($firm),
            'account' => AccountResource::make($account),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Firm $firm
     * @param Account $account
     *
     * @return Response
     */
    public function edit(Firm $firm, Account $account, Currencies $currencies): Response
    {
        FirmResource::withoutWrapping();
        AccountResource::withoutWrapping();

        return inertia('AccountEdit', [
            'firm' => FirmResource::make($firm),
            'account' => AccountResource::make($account),
            'currencies' => $currencies->all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Firm $firm
     * @param Account $account
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Firm $firm, Account $account): RedirectResponse
    {
        $account->update(
            $request->validate([
                'title' => 'required|string|max:255',
                'balance' => 'required|numeric|min:-1000000000|max:1000000000',
            ])
        );

        return Redirect::route('firms.accounts.edit', compact('firm', 'account'), 303);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Firm $firm
     * @param Account $account
     *
     * @return RedirectResponse
     */
    public function destroy(Firm $firm, Account $account): RedirectResponse
    {
        $account->delete();

        return Redirect::route('firms.accounts.edit', compact('firm', 'account'), 303);
    }
}
