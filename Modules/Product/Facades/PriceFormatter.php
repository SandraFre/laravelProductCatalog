<?php

declare(strict_types = 1);

namespace Modules\Product\Facades;

use Illuminate\Support\Facades\Facade;

/**
* @method static string formatWithCurrencyCode(float $price, string $currencyCode = 'EUR')
* @method static string formatPrice(float $price, int $decimal = 2)
*/

class PriceFormatter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'price-formatter';
    }
}
