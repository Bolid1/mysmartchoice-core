<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Account;
use App\Models\Firm;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     *
     * @return bool
     */
    public function viewAny(User $user, Firm $firm): bool
    {
        $firmId = $firm->id;

        return $user->noTokenOrTokenCan("view-firm-{$firmId}-accounts")
               && $user->isInFirm($firmId);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Account $account
     *
     * @return bool
     */
    public function view(User $user, Account $account): bool
    {
        $firmId = $account->firm_id;

        return $user->noTokenOrTokenCan("view-firm-{$firmId}-accounts")
               && $user->isInFirm($firmId);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user, Firm $firm): bool
    {
        $firmId = $firm->id;

        return $user->noTokenOrTokenCan("create-firm-{$firmId}-accounts")
               && $user->isInFirm($firmId);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Account $account
     *
     * @return bool
     */
    public function update(User $user, Account $account): bool
    {
        $firmId = $account->firm_id;

        return $user->noTokenOrTokenCan("update-firm-{$firmId}-accounts")
               && $user->isInFirm($firmId);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Account $account
     *
     * @return bool
     */
    public function delete(User $user, Account $account): bool
    {
        $firmId = $account->firm_id;

        return $user->noTokenOrTokenCan("delete-firm-{$firmId}-accounts")
               && $user->isInFirm($firmId);
    }
}
