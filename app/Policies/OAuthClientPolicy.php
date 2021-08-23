<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\OAuthClient;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Request;
use function route;

class OAuthClientPolicy
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OAuthClient  $oAuthClient
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, OAuthClient $oAuthClient)
    {
        return $user->clients()->where('id', $oAuthClient->id)->exists();
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
     * @param  \App\Models\OAuthClient  $oAuthClient
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, OAuthClient $oAuthClient)
    {
        return $user->clients()->where('id', $oAuthClient->id)->exists();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OAuthClient  $oAuthClient
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, OAuthClient $oAuthClient)
    {
        return $user->clients()->where('id', $oAuthClient->id)->exists();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OAuthClient  $oAuthClient
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, OAuthClient $oAuthClient)
    {
        return $user->clients()->where('id', $oAuthClient->id)->exists();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OAuthClient  $oAuthClient
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, OAuthClient $oAuthClient)
    {
        return $user->clients()->where('id', $oAuthClient->id)->exists();
    }

    /**
     * @param User $user
     * @param OAuthClient $oAuthClient
     *
     * @return bool Может ли пользователь пропустить окошко "вы даёте доступ, бла-бла-бла"?
     */
    public function skipsAuthorization(User $user, OAuthClient $oAuthClient): bool
    {
        return Request::input('skips_authorization')
               && $user->getKey() === $oAuthClient->user_id
               && $oAuthClient->redirect === route('oauth.callbacks.test_code')
            ;
    }

    /**
     * @param User $user
     * @param OAuthClient $oAuthClient
     *
     * @return bool Может ли пользователь создавать тестовые токены на этом клиенте?
     */
    public function testExchange(User $user, OAuthClient $oAuthClient): bool
    {
        return $user->getKey() === $oAuthClient->user_id
               && $oAuthClient->redirect === route('oauth.callbacks.test_code')
            ;
    }
}
