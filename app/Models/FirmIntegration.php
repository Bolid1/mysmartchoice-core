<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

/**
 * Integration install in firm.
 *
 * One integration can be installed in one firm many times with different settings.
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $firm_id
 * @property-read Firm $firm
 * @property int $integration_id
 * @property-read Integration $integration
 * @property string $status
 * @property array|null $settings
 * @method static Builder|FirmIntegration newModelQuery()
 * @method static Builder|FirmIntegration newQuery()
 * @method static Builder|FirmIntegration query()
 * @method static Builder|FirmIntegration whereCreatedAt($value)
 * @method static Builder|FirmIntegration whereFirmId($value)
 * @method static Builder|FirmIntegration whereId($value)
 * @method static Builder|FirmIntegration whereIntegrationId($value)
 * @method static Builder|FirmIntegration whereSettings($value)
 * @method static Builder|FirmIntegration whereStatus($value)
 * @method static Builder|FirmIntegration whereUpdatedAt($value)
 * @mixin Eloquent
 */
class FirmIntegration extends Pivot
{
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

    protected $fillable = [
        'firm_id',
        'firm',
        'integration_id',
        'integration',
        'status',
        'settings',
    ];

    public function firm(): BelongsTo
    {
        return $this->belongsTo(Firm::class);
    }

    public function integration(): BelongsTo
    {
        return $this->belongsTo(Integration::class);
    }
}
