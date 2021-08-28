<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\OAuthClient;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Request;
use JetBrains\PhpStorm\Pure;
use function route;

class OAuthClientPolicy
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
        return $user->noTokenOrTokenCan('view-oauth_clients');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param OAuthClient $oAuthClient
     *
     * @return bool
     */
    #[Pure]
    public function view(User $user, OAuthClient $oAuthClient): bool
    {
        return $user->noTokenOrTokenCan('view-oauth_clients')
               && $oAuthClient->isOwner($user);
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
        return $user->noTokenOrTokenCan('create-oauth_clients');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param OAuthClient $oAuthClient
     *
     * @return bool
     */
    #[Pure]
    public function update(User $user, OAuthClient $oAuthClient): bool
    {
        return $user->noTokenOrTokenCan('update-oauth_clients')
               && $oAuthClient->isOwner($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param OAuthClient $oAuthClient
     *
     * @return bool
     */
    #[Pure]
    public function delete(User $user, OAuthClient $oAuthClient): bool
    {
        return $user->noTokenOrTokenCan('delete-oauth_clients')
               && $oAuthClient->isOwner($user);
    }

    /**
     * @param User $user
     * @param OAuthClient $oAuthClient
     *
     * @return bool Может ли пользователь пропустить окошко "вы даёте доступ, бла-бла-бла"?
     */
    #[Pure]
    public function skipsAuthorization(User $user, OAuthClient $oAuthClient): bool
    {
        return $user->noToken()
               && Request::input('skips_authorization')
               && $oAuthClient->isOwner($user)
               && $oAuthClient->redirect === route('oauth.callbacks.test_code')
            ;
    }

    /**
     * @param User $user
     * @param OAuthClient $oAuthClient
     *
     * @return bool Может ли пользователь создавать тестовые токены на этом клиенте?
     */
    #[Pure]
    public function testExchange(User $user, OAuthClient $oAuthClient): bool
    {
        return $user->noToken()
               && $oAuthClient->isOwner($user)
               && $oAuthClient->redirect === route('oauth.callbacks.test_code')
            ;
    }
}
