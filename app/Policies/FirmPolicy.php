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
        return $user->isInFirm($firm->getKey())
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
        return $user->isInFirm($firm->getKey())
            ? $this->allow()
            : $this->deny('You are not authorized to view users of the firm.');
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
        $firmsCount = $user->firms_count;
        if (null === $firmsCount) {
            $firmsCount = $user->loadCount('firms')->firms_count;
        }

        return $firmsCount < Firm::PER_USER_LIMIT;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Firm $firm
     * @return bool
     */
    public function update(User $user, Firm $firm): bool
    {
        return $user->isInFirm($firm->getKey());
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Firm $firm
     * @return bool
     */
    public function delete(User $user, Firm $firm): bool
    {
        return $user->isInFirm($firm->getKey());
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Firm $firm
     * @return bool
     */
    public function restore(User $user, Firm $firm): bool
    {
        return $user->isInFirm($firm->getKey());
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Firm $firm
     * @return bool
     */
    public function forceDelete(User $user, Firm $firm): bool
    {
        return $user->isInFirm($firm->getKey());
    }

    public function manageIntegrations(User $user, Firm $firm): bool
    {
        return $user->isInFirm($firm->getKey());
    }
}
