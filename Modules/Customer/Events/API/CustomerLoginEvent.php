<?php

declare(strict_types=1);

namespace Modules\Customer\Events\API;

use Modules\Customer\Enum\CustomerAuthLogTypeEnum;
use Modules\Customer\Events\API\Abstracts\CustomerAuthAbstract;


class CustomerLoginEvent extends CustomerAuthAbstract
{
    public function getType(): string
    {
        return CustomerAuthLogTypeEnum::loggedIn()->id();
    }

}
