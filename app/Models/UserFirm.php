<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

/**
 * The connection between user and firm.
 *
 * @property int $id Идентификатор записи
 * @property int $user_id Идентификатор пользователя
 * @property int $firm_id Идентификатор фирмы
 * @property Carbon|null $created_at Дата создания записи
 * @property Carbon|null $updated_at Дата последнего обновления записи
 * @method static Builder|UserFirm newModelQuery()
 * @method static Builder|UserFirm newQuery()
 * @method static Builder|UserFirm query()
 * @method static Builder|UserFirm whereFirmId($value)
 * @method static Builder|UserFirm whereId($value)
 * @method static Builder|UserFirm whereUserId($value)
 * @method static Builder|UserFirm whereCreatedAt($value)
 * @method static Builder|UserFirm whereUpdatedAt($value)
 * @mixin Eloquent
 */
class UserFirm extends Pivot
{
}
