<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\AccountFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Account.
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $title
 * @property float $balance
 * @property int $firm_id
 * @property Carbon|null $deleted_at
 * @property Firm $firm
 * @property string $currency
 *
 * @method static AccountFactory factory(...$parameters)
 * @method static Builder|Account newModelQuery()
 * @method static Builder|Account newQuery()
 * @method static Builder|Account query()
 * @method static Builder|Account whereBalance($value)
 * @method static Builder|Account whereCreatedAt($value)
 * @method static Builder|Account whereId($value)
 * @method static Builder|Account whereTitle($value)
 * @method static Builder|Account whereUpdatedAt($value)
 * @method static Builder|Account whereFirmId($value)
 * @method static Builder|Account whereDeletedAt($value)
 * @method static Builder|Account whereCurrency($value)
 * @method static \Illuminate\Database\Query\Builder|Account onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Account withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Account withoutTrashed()
 * @mixin Eloquent
 */
class Account extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'title' => 'string',
        'balance' => 'float',
        'firm_id' => 'int',
    ];

    protected $fillable = [
        'firm_id',
        'title',
        'balance',
        'currency',
    ];

    /**
     * @return BelongsTo one account can belong to only firm
     */
    public function firm(): BelongsTo
    {
        return $this->belongsTo(Firm::class);
    }
}
