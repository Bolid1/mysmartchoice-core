<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Passport\Client;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Token;

/**
 * App\Models\User.
 *
 * @property int $id Идентификатор пользователя
 * @property string $name Имя пользователя
 * @property string $email Email
 * @property Carbon|null $email_verified_at Дата, когда пользователь подтвердил свой email
 * @property string $password Хэш пароля
 * @property string|null $remember_token Хэш, по которому приложение сможет "вспомнить" пользователя, когда он зайдёт через много времени
 * @property Carbon|null $created_at Дата создания записи
 * @property Carbon|null $updated_at Дата последнего обновления записи
 * @property Collection|Firm[] $firms
 * @property int|null $firms_count
 * @property DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property int|null $notifications_count
 * @property Collection|Client[] $clients
 * @property int|null $clients_count
 * @property Collection|Token[] $tokens
 * @property int|null $tokens_count
 * @property Collection|User[] $comrades
 * @property int|null $comrades_count
 * @property Collection|Integration[] $integrations
 * @property int|null $integrations_count
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return BelongsToMany one user can be in many firms at one moment of time
     */
    public function firms(): BelongsToMany
    {
        return $this->belongsToMany(Firm::class, UserFirm::class);
    }

    /**
     * @return BelongsToMany the users, that works in the same firms, as current user
     */
    public function comrades(): BelongsToMany
    {
        $relation = $this->belongsToMany(__CLASS__, UserFirm::class);

        // Remove links for current entity
        $relation->getBaseQuery()->wheres = [];
        $relation->getBaseQuery()->bindings['where'] = [];

        // Determine FQN for firm identifier in firms table
        $firmModelIdentifier = (new Firm())->users()->getQualifiedForeignPivotKeyName();

        return $relation
            // Setup link for user comrades in firm_user table
            ->wherePivotIn('firm_id', $this->firms()->getQuery()->select($firmModelIdentifier))
            // Without this replace `user_firm`.`user_id` as `pivot_user_id` will be selected
            ->select($relation->qualifyColumn('*'))
            ;
    }

    public function integrations(): HasMany
    {
        return $this->hasMany(Integration::class, 'owner_id');
    }

    /**
     * @param int $anotherUserId
     *
     * @return bool Does user has comrade with given identifier
     */
    public function hasComrade(int $anotherUserId): bool
    {
        $query = $this->comrades();

        return $query
            ->where(
                $query->qualifyColumn('id'),
                '=',
                $anotherUserId
            )
            ->exists()
            ;
    }

    /**
     * @param int $firmId
     *
     * @return bool Does current user works in firm with given identifier?
     */
    public function isInFirm(int $firmId): bool
    {
        $query = $this->firms();

        return $query
            ->where(
                $query->qualifyColumn('id'),
                '=',
                $firmId
            )
            ->exists()
            ;
    }

    public function oauthClients(): HasMany
    {
        return $this->hasMany(Client::class);
    }
}
