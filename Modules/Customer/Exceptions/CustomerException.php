<?php

declare(strict_types=1);

namespace  Modules\Customer\Exceptions;

use Exception;
use Illuminate\Http\Response;

class CustomerException extends Exception
{
    public static function noCustomer(): CustomerException
    {
        return new static ('Your data not found', Response::HTTP_NOT_FOUND);
    }
}
