<?php

declare(strict_types=1);

namespace App\Enum;

use App\Enum\Abstracts\Enumerable;
use ReflectionException;

class ProductTypeEnum extends Enumerable
{
    final public static function physical(): ProductTypeEnum
    {
        return self::make('physical', 'Physical', 'Product is physical');
    }

    final public static function virtual(): ProductTypeEnum
    {
        return self::make('virtual', 'Virtual', 'Product is virtual');
    }

    
}
