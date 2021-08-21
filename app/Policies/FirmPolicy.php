<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Firm;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class FirmPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return bool
     */
    public function viewAny(/*User $user*/): bool
    {
        // @TODO: $user->isActive
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Firm $firm
     *
     * @return Response
     */
    public function view(User $user, Firm $firm): Response
    {
        return $user->isInFirm($firm->id)
            ? $this->allow()
            : $this->deny('You are not in the firm.');
    }

    /**
     * Determine whether the user can view the firm users.
     *
     * @param User $user
     * @param Firm $firm
     *
     * @return Response
     */
    public function viewUsers(User $user, Firm $firm): Response
    {
        return $user->isInFirm($firm->id)
            ? $this->allow()
            : $this->deny('You are not authorized to view users of the firm.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @return bool
     */
    public function create(/*User $user*/): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return bool
     */
    public function update(/*User $user, Firm $firm*/): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return bool
     */
    public function delete(/*User $user, Firm $firm*/): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return bool
     */
    public function restore(/*User $user, Firm $firm*/): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return bool
     */
    public function forceDelete(/*User $user, Firm $firm*/): bool
    {
        return false;
    }
}