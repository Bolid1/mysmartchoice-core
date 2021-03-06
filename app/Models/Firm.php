<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\FirmFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection as BaseCollection;

/**
 * A business concern, especially one involving a
 * partnership of two or more people.
 *
 * But in our case can be only user in firm.
 *
 * @property int $id Идентификатор фирмы
 * @property string $title Название пользователя
 * @property Carbon|null $created_at Дата создания записи
 * @property Carbon|null $updated_at Дата последнего обновления записи
 * @property Collection|User[] $users
 * @property int|null $users_count
 * @property Collection|Account[] $accounts
 * @property int|null $accounts_count
 * @property Collection|FirmIntegration[] $integrationsInstalls
 * @property int|null $integrations_installs_count
 * @property Collection|UserFirm[] $usersLinks
 * @property int|null $users_links_count
 *
 * @method static FirmFactory factory(...$parameters)
 * @method static Builder|Firm newModelQuery()
 * @method static Builder|Firm newQuery()
 * @method static Builder|Firm query()
 * @method static Builder|Firm whereId($value)
 * @method static Builder|Firm whereTitle($value)
 * @method static Builder|Firm whereUpdatedAt($value)
 * @method static Builder|Firm whereCreatedAt($value)
 * @mixin Eloquent
 */
class Firm extends Model
{
    use HasFactory;

    /** @var positive-int Max number of firms per user. */
    public const PER_USER_LIMIT = 10;

    protected $visible = [
        'id',
        'title',
        self::CREATED_AT,
        self::UPDATED_AT,
    ];

    protected $fillable = [
        'title',
    ];

    /**
     * @return BelongsToMany in firm can be many users
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, UserFirm::class);
    }

    /**
     * @return HasMany in firm can be many users
     */
    public function usersLinks(): HasMany
    {
        return $this->hasMany(UserFirm::class);
    }

    /**
     * @return HasMany There are many accounts in firm
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    /**
     * @return HasMany There are many installs of different integrations can be in firm
     */
    public function integrationsInstalls(): HasMany
    {
        return $this->hasMany(FirmIntegration::class);
    }

    public function getBalanceByCurrencies(): BaseCollection
    {
        return $this
            ->accounts
            ->groupBy('currency')
            ->map(
                static fn (BaseCollection $accounts) => $accounts->sum('balance'),
            );
    }
}
