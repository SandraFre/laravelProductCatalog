<?php

declare(strict_types=1);

namespace Modules\Customer\Events\API;

use Modules\Customer\Enum\CustomerAuthLogTypeEnum;
use Modules\Customer\Events\API\Abstracts\CustomerAuthAbstract;


class CustomerLogoutEvent extends CustomerAuthAbstract
{
   public function getType(): string
   {
        return CustomerAuthLogTypeEnum::loggedOut()->id();
   }


}
