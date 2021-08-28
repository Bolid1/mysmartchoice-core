<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Integration;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use JetBrains\PhpStorm\Pure;

class IntegrationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     *
     * @return bool
     */
    #[Pure]
    public function viewAny(User $user): bool
    {
        return $user->noTokenOrTokenCan('view-integrations');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Integration $integration
     *
     * @return bool
     */
    #[Pure]
    public function view(User $user, Integration $integration): bool
    {
        return $user->noTokenOrTokenCan('view-integrations')
            && (Integration::STATUS_AVAILABLE === $integration->status
               || $integration->isOwner($user))
        ;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     *
     * @return bool
     */
    #[Pure]
    public function create(User $user): bool
    {
        return $user->noTokenOrTokenCan('create-integrations');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Integration $integration
     *
     * @return bool
     */
    #[Pure]
    public function update(User $user, Integration $integration): bool
    {
        return $user->noTokenOrTokenCan('update-integrations')
               && $integration->isOwner($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Integration $integration
     *
     * @return bool
     */
    #[Pure]
    public function delete(User $user, Integration $integration): bool
    {
        return $user->noTokenOrTokenCan('delete-integrations')
               && Integration::STATUS_DRAFT === $integration->status
               && $integration->isOwner($user);
    }

    /**
     * @param User $user
     * @param Integration $integration
     *
     * @return bool Can user install this integration into any firm?
     */
    #[Pure]
    public function install(User $user, Integration $integration): bool
    {
        return Integration::STATUS_AVAILABLE === $integration->status
               || $integration->isOwner($user);
    }
}
