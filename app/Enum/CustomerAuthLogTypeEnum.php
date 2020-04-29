<?php

declare(strict_types=1);

namespace App\Enum;

use App\Enum\Abstracts\Enumerable;

class CustomerAuthLogTypeEnum extends Enumerable
{
    final public static function loggedIn(): CustomerAuthLogTypeEnum
    {
        return self::make('logged_in', __('Logged In'));
    }

    final public static function loggedOut(): CustomerAuthLogTypeEnum
    {
        return self::make('logged_out', __('Logged Out'));
    }

}
