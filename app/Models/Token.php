<?php

declare(strict_types=1);

namespace App\Models;

use App\Collections\TokensCollection;
use App\Models\OAuth\Client;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\Token.
 *
 * @property string $id
 * @property int|null $user_id
 * @property string $client_id
 * @property string|null $name
 * @property array|null $scopes
 * @property bool $revoked
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property Carbon|null $expires_at
 * @property Client $client
 * @property User|null $user
 *
 * @method static TokensCollection|static[] all($columns = ['*'])
 * @method static TokensCollection|static[] get($columns = ['*'])
 * @method static Builder|Token newModelQuery()
 * @method static Builder|Token newQuery()
 * @method static Builder|Token query()
 * @method static Builder|Token whereClientId($value)
 * @method static Builder|Token whereCreatedAt($value)
 * @method static Builder|Token whereExpiresAt($value)
 * @method static Builder|Token whereId($value)
 * @method static Builder|Token whereName($value)
 * @method static Builder|Token whereRevoked($value)
 * @method static Builder|Token whereScopes($value)
 * @method static Builder|Token whereUpdatedAt($value)
 * @method static Builder|Token whereUserId($value)
 * @mixin Eloquent
 */
class Token extends \Laravel\Passport\Token
{
    public function newCollection(array $models = []): TokensCollection
    {
        return new TokensCollection($models);
    }
}
