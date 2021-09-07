<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Enums\Currencies;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountRequest;
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
        $this->authorizeResource(Account::class.',firm', 'account,firm');
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
        return inertia('Firms/Accounts', [
            'firm' => $firm,
            'accounts' => $firm->accounts()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Firm $firm
     * @param Currencies $currencies
     *
     * @return Response
     */
    public function create(Firm $firm, Currencies $currencies): Response
    {
        return inertia('Firms/AccountEdit', [
            'firm' => $firm,
            'account' => Account::make([
                'firm_id' => $firm->id,
            ]),
            'currencies' => $currencies->all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAccountRequest $request
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
        return inertia('Firms/Account', [
            'firm' => $firm,
            'account' => $account,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Firm $firm
     * @param Account $account
     * @param Currencies $currencies
     *
     * @return Response
     */
    public function edit(Firm $firm, Account $account, Currencies $currencies): Response
    {
        return inertia('Firms/AccountEdit', [
            'firm' => $firm,
            'account' => $account,
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
                'title' => 'sometimes|required|string|max:255',
                'balance' => 'sometimes|required|numeric|min:-1000000000|max:1000000000',
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

        return Redirect::route('firms.accounts.index', compact('firm'), 303);
    }
}
