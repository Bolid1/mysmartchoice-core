<?php

declare(strict_types=1);

namespace App\Models\OAuth;

use App\Models\User;
use Database\Factories\OAuth\ClientFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\AuthCode;
use Laravel\Passport\Client as PassportClient;
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
 * @method static ClientFactory factory(...$parameters)
 * @method static Builder|Client newModelQuery()
 * @method static Builder|Client newQuery()
 * @method static Builder|Client query()
 * @method static Builder|Client whereId($value)
 * @method static Builder|Client whereCreatedAt($value)
 * @method static Builder|Client whereUpdatedAt($value)
 * @method static Builder|Client whereName($value)
 * @method static Builder|Client wherePasswordClient($value)
 * @method static Builder|Client wherePersonalAccessClient($value)
 * @method static Builder|Client whereProvider($value)
 * @method static Builder|Client whereRedirect($value)
 * @method static Builder|Client whereRevoked($value)
 * @method static Builder|Client whereSecret($value)
 * @method static Builder|Client whereUserId($value)
 * @mixin Eloquent
 */
class Client extends PassportClient
{
    protected $visible = [
        'id',
        'created_at',
        'updated_at',
        'user_id',
        'name',
        'redirect',
    ];

    protected $casts = [
        'grant_types' => 'array',
        'personal_access_client' => 'bool',
        'password_client' => 'bool',
        'revoked' => 'bool',
        'user_id' => 'int',
    ];

    /**
     * Determine if the client should skip the authorization prompt.
     *
     * @return bool
     */
    public function skipsAuthorization(): bool
    {
        return Gate::allows('skips-authorization', $this);
    }

    public function isOwner(User|int $user): bool
    {
        return $this->user_id === ($user instanceof User ? $user->id : $user);
    }
}
