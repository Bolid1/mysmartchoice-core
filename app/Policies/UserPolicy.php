<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Firm;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return bool
     */
    public function viewAny(User $user, Firm $firm): bool
    {
        return $user->noToken()
               || $user->tokenCan('view-firms-users')
               || $user->tokenCan("view-firm-{$firm->id}-users")
            ;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     *
     * @return Response
     */
    public function view(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return $user->noTokenOrTokenCan('view-me');
        }

        // todo: view-firm-{firm}-users

        return $user->noTokenOrTokenCan('view-firms-users')
               && $user->hasComrade($model->id);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     *
     * @return Response
     */
    public function viewEmail(User $user, User $model): Response
    {
        return $user->noTokenOrTokenCan('view-me') && $user->id === $model->id
            ? $this->allow()
            : $this->deny('You can view only yours email.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $model
     *
     * @return bool
     */
    public function update(User $user, User $model): bool
    {
        return $user->noTokenOrTokenCan('update-me') && $user->id === $model->id;
    }
}
