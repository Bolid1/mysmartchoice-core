<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Integration;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class IntegrationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     *
     * @return Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Integration $integration
     *
     * @return Response|bool
     */
    public function view(User $user, Integration $integration)
    {
        return Integration::STATUS_AVAILABLE === $integration->status
               || $integration->owner_id === $user->id
        ;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     *
     * @return Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Integration $integration
     *
     * @return Response|bool
     */
    public function update(User $user, Integration $integration)
    {
        return $integration->owner_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Integration $integration
     *
     * @return Response|bool
     */
    public function delete(User $user, Integration $integration)
    {
        return $integration->status === Integration::STATUS_DRAFT
               && $integration->owner_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Integration $integration
     *
     * @return Response|bool
     */
    public function restore(User $user, Integration $integration)
    {
        return $integration->owner_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Integration $integration
     *
     * @return Response|bool
     */
    public function forceDelete(User $user, Integration $integration)
    {
        return $this->delete($user, $integration);
    }

    /**
     * @param User $user
     * @param Integration $integration
     *
     * @return bool Can user install this integration into any firm?
     */
    public function install(User $user, Integration $integration): bool
    {
        return Integration::STATUS_AVAILABLE === $integration->status
               || $user->integrations()->find($integration->id);
    }
}
