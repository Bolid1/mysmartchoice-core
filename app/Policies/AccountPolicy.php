<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Account;
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
    public function viewAny(User $user): bool
    {
        return true;
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
        return $user->firms()->where($user->firms()->qualifyColumn('id'), $account->firm_id)->exists()
        ;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
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
        return $user->firms()->where($user->firms()->qualifyColumn('id'), $account->firm_id)->exists()
        ;
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
        return $user->firms()->where($user->firms()->qualifyColumn('id'), $account->firm_id)->exists()
        ;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Account $account
     *
     * @return bool
     */
    public function restore(User $user, Account $account): bool
    {
        return $user->firms()->where($user->firms()->qualifyColumn('id'), $account->firm_id)->exists()
        ;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Account $account
     *
     * @return bool
     */
    public function forceDelete(User $user, Account $account): bool
    {
        return $user->firms()->where($user->firms()->qualifyColumn('id'), $account->firm_id)->exists()
        ;
    }
}
