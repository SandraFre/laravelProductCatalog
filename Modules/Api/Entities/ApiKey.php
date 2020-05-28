<?php

declare(strict_types=1);

namespace Modules\Api\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Api\Entities\ApiKey
 *
 * @property int $id
 * @property string $title
 * @property string $app_key
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Api\Entities\ApiKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Api\Entities\ApiKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Api\Entities\ApiKey query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Api\Entities\ApiKey whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Api\Entities\ApiKey whereAppKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Api\Entities\ApiKey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Api\Entities\ApiKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Api\Entities\ApiKey whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Api\Entities\ApiKey whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApiKey extends Model
{
    protected $fillable = [
        'title',
        'app_key',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
