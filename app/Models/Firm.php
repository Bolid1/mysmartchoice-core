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

    /**
     * @return BelongsToMany in firm can be many users
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, UserFirm::class);
    }

    /**
     * @return HasMany There are many accounts in firm
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }
}
