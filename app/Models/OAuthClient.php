<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\OAuthClientFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\AuthCode;
use Laravel\Passport\Client;
use Laravel\Passport\Token;

/**
 * An application making protected resource requests on behalf of the
 * resource owner and with its authorization.
 *
 * @see https://datatracker.ietf.org/doc/html/rfc6749
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $user_id
 * @property string $name
 * @property string|null $secret
 * @property string|null $provider
 * @property string $redirect
 * @property bool $personal_access_client
 * @property bool $password_client
 * @property bool $revoked
 * @property Collection|AuthCode[] $authCodes
 * @property int|null $auth_codes_count
 * @property string|null $plain_secret
 * @property Collection|Token[] $tokens
 * @property int|null $tokens_count
 * @property User|null $user
 *
 * @method static OAuthClientFactory factory(...$parameters)
 * @method static Builder|OAuthClient newModelQuery()
 * @method static Builder|OAuthClient newQuery()
 * @method static Builder|OAuthClient query()
 * @method static Builder|OAuthClient whereId($value)
 * @method static Builder|OAuthClient whereCreatedAt($value)
 * @method static Builder|OAuthClient whereUpdatedAt($value)
 * @method static Builder|OAuthClient whereName($value)
 * @method static Builder|OAuthClient wherePasswordClient($value)
 * @method static Builder|OAuthClient wherePersonalAccessClient($value)
 * @method static Builder|OAuthClient whereProvider($value)
 * @method static Builder|OAuthClient whereRedirect($value)
 * @method static Builder|OAuthClient whereRevoked($value)
 * @method static Builder|OAuthClient whereSecret($value)
 * @method static Builder|OAuthClient whereUserId($value)
 * @mixin Eloquent
 */
class OAuthClient extends Client
{
    /**
     * Determine if the client should skip the authorization prompt.
     *
     * @return bool
     */
    public function skipsAuthorization(): bool
    {
        return Gate::allows('skips-authorization', $this);
    }
}
