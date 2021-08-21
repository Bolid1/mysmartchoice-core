<?php

declare(strict_types=1);

namespace App\Policies;

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
    public function viewAny(/*User $user*/): bool
    {
        // @TODO: $user->isActive
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     *
     * @return Response
     */
    public function view(User $user, User $model): Response
    {
        return $user->id === $model->id || $user->hasComrade($model->id)
            ? $this->allow()
            : $this->deny('You are not in the same firm with this user.');
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
        return $user->id === $model->id
            ? $this->allow()
            : $this->deny('You can view only yours email.');
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
     * @param User $user
     * @param User $model
     *
     * @return bool
     */
    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return bool
     */
    public function delete(/*User $user, User $model*/): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return bool
     */
    public function restore(/*User $user, User $model*/): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return bool
     */
    public function forceDelete(/*User $user, User $model*/): bool
    {
        return false;
    }
}