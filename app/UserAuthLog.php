<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\UserAuthLog
 *
 * @property int $id
 * @property int $user_id
 * @property string $token_id
 * @property \Illuminate\Support\Carbon $event_time
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserAuthLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserAuthLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserAuthLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserAuthLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserAuthLog whereEventTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserAuthLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserAuthLog whereTokenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserAuthLog whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserAuthLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserAuthLog whereUserId($value)
 * @mixin \Eloquent
 */

class UserAuthLog extends Model
{
    protected $fillable = [
        'user_id',
        'token_id',
        'event_time',
        'type',
    ];

    protected $dates = [
        'event_time',
    ];

    

}
