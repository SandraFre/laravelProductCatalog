<?php
declare(strict_types=1);

namespace Modules\ContactUs\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Modules\ContactUs\Entities\ContactMessage
 *
 * @property int $id
 * @property string|null $client_name
 * @property string $client_email
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\ContactUs\Entities\ContactMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\ContactUs\Entities\ContactMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\ContactUs\Entities\ContactMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\ContactUs\Entities\ContactMessage whereClientEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\ContactUs\Entities\ContactMessage whereClientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\ContactUs\Entities\ContactMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\ContactUs\Entities\ContactMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\ContactUs\Entities\ContactMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\ContactUs\Entities\ContactMessage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContactMessage extends Model
{
    protected $fillable = [
        'client_name',
        'client_email',
        'message',
    ];
}
