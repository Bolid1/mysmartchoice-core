<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use App\Models\Firm;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

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
     * @return AnonymousResourceCollection
     */
    public function index(Firm $firm): AnonymousResourceCollection
    {
        return AccountResource::collection($firm->accounts()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAccountRequest $request
     * @param Firm $firm
     *
     * @return JsonResource
     */
    public function store(StoreAccountRequest $request, Firm $firm): JsonResource
    {
        return AccountResource::make(
            Account::create(
                ['firm_id' => $firm->id] + $request->validated()
            )
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Firm $firm
     * @param Account $account
     *
     * @return JsonResource
     */
    public function show(Firm $firm, Account $account): JsonResource
    {
        return AccountResource::make($account);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Firm $firm
     * @param Account $account
     *
     * @return JsonResource
     */
    public function update(Request $request, Firm $firm, Account $account): JsonResource
    {
        $account->update(
            $request->validate([
                'title' => 'required|string|max:255',
                'balance' => 'required|numeric|min:-1000000000|max:1000000000',
            ])
        );

        return AccountResource::make($account);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Firm $firm
     * @param Account $account
     *
     * @return JsonResource
     */
    public function destroy(Firm $firm, Account $account): JsonResource
    {
        $account->delete();

        return AccountResource::make($account);
    }
}
