<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\FirmIntegrationFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

/**
 * Fixme: need description.
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $firm_id
 * @property Firm $firm
 * @property int $integration_id
 * @property Integration $integration
 * @property string $status
 * @property mixed|null $settings
 *
 * @method static FirmIntegrationFactory factory(...$parameters)
 * @method static Builder|FirmIntegration newModelQuery()
 * @method static Builder|FirmIntegration newQuery()
 * @method static Builder|FirmIntegration query()
 * @method static Builder|FirmIntegration whereCreatedAt($value)
 * @method static Builder|FirmIntegration whereUpdatedAt($value)
 * @method static Builder|FirmIntegration whereFirmId($value)
 * @method static Builder|FirmIntegration whereId($value)
 * @method static Builder|FirmIntegration whereIntegrationId($value)
 * @method static Builder|FirmIntegration whereSettings($value)
 * @method static Builder|FirmIntegration whereStatus($value)
 * @mixin Eloquent
 */
class FirmIntegration extends Pivot
{
    use HasFactory;

    public $incrementing = true;

    public const STATUS_INSTALLABLE = 'installable';
    public const STATUS_INSTALLED = 'installed';

    protected $casts = [
        'firm_id' => 'int',
        'integration_id' => 'int',
        'status' => 'string',
        'settings' => 'json',
    ];

    protected $attributes = [
        'status' => self::STATUS_INSTALLABLE,
    ];

    protected $visible = [
        'id',
        self::CREATED_AT,
        self::UPDATED_AT,
        'firm_id',
        'firm',
        'integration_id',
        'integration',
        'status',
    ];

    protected $hidden = [
        'settings',
    ];

    protected $guarded = ['*'];

    public function firm(): BelongsTo
    {
        return $this->belongsTo(Firm::class);
    }

    public function integration(): BelongsTo
    {
        return $this->belongsTo(Integration::class);
    }
}
