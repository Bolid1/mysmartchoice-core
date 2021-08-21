<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\FirmIntegration;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FirmIntegrationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FirmIntegration  $firmIntegration
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, FirmIntegration $firmIntegration)
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FirmIntegration  $firmIntegration
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, FirmIntegration $firmIntegration): bool
    {
        $firmId = $firmIntegration->firm_id;

        return $firmId && $user->firms->where('id', $firmId)->first();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FirmIntegration  $firmIntegration
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, FirmIntegration $firmIntegration)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FirmIntegration  $firmIntegration
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, FirmIntegration $firmIntegration)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FirmIntegration  $firmIntegration
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, FirmIntegration $firmIntegration)
    {
        return false;
    }
}