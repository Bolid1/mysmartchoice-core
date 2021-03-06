<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\IntegrationFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use InvalidArgumentException;
use function data_get;
use function is_iterable;

/**
 * External application, that can interact with current app.
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $owner_id
 * @property User $owner
 * @property string $title
 * @property string $description
 * @property string $status
 * @property array|null $settings
 * @property Collection|FirmIntegration[] $integrationsInstalls
 * @property int|null $integrations_installs_count
 * @property string|null $javascript_file
 * @property string|null $authorize_uri
 * @property string $auth
 *
 * @method static IntegrationFactory factory(...$parameters)
 * @method static Builder|Integration newModelQuery()
 * @method static Builder|Integration newQuery()
 * @method static Builder|Integration query()
 * @method static Builder|Integration whereCreatedAt($value)
 * @method static Builder|Integration whereDescription($value)
 * @method static Builder|Integration whereId($value)
 * @method static Builder|Integration whereOwnerId($value)
 * @method static Builder|Integration whereStatus($value)
 * @method static Builder|Integration whereTitle($value)
 * @method static Builder|Integration whereUpdatedAt($value)
 * @method static Builder|Integration whereDeletedAt($value)
 * @method static Builder|Integration whereSettings($value)
 * @method static \Illuminate\Database\Query\Builder|Integration onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Integration withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Integration withoutTrashed()
 * @mixin Eloquent
 */
class Integration extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_AVAILABLE = 'available';
    public const AUTH_OAUTH2 = 'oauth2';
    public const AUTH_NONE = 'none';

    protected $casts = [
        'owner_id' => 'int',
        'title' => 'string',
        'description' => 'string',
        'status' => 'string',
        'settings' => 'json',
    ];

    protected $attributes = [
        'status' => self::STATUS_DRAFT,
    ];

    protected $visible = [
        'id',
        self::CREATED_AT,
        self::UPDATED_AT,
        'owner_id',
        'owner',
        'title',
        'description',
        'status',
        'settings',
    ];

    protected $fillable = [
        'owner_id',
        'title',
        'description',
        'settings',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function isOwner(User|int $user): bool
    {
        return $this->owner_id === ($user instanceof User ? $user->id : $user);
    }

    public function setSettingsAttribute($settings): self
    {
        if (!is_iterable($settings)) {
            throw new InvalidArgumentException('Unexpected value for integration settings');
        }

        foreach ($settings as $key => $value) {
            if ($this->hasSetMutator($key)) {
                $this->setMutatedAttributeValue($key, $value);
            } else {
                $this->fillJsonAttribute("settings->{$key}", $value);
            }
        }

        return $this;
    }

    public function getAuthAttribute(): string
    {
        return data_get($this->settings, 'auth', self::AUTH_NONE);
    }

    public function getJavascriptFileAttribute(): ?string
    {
        return data_get($this->settings, 'javascript_file');
    }

    public function setJavascriptFileAttribute(string $file): self
    {
        return $this->fillJsonAttribute('settings->javascript_file', $file);
    }

    public function getAuthorizeUriAttribute(): ?string
    {
        return data_get($this->settings, 'authorize_uri');
    }

    public function setAuthorizeUriAttribute(string $file): self
    {
        return $this->fillJsonAttribute('settings->authorize_uri', $file);
    }
}
