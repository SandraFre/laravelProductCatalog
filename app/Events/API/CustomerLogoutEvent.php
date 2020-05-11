<?php

declare(strict_types=1);

namespace App\Events\API;

use Modules\Customer\Enum\CustomerAuthLogTypeEnum;
use App\Events\API\Abstracts\CustomerAuthAbstract;


class CustomerLogoutEvent extends CustomerAuthAbstract
{
   public function getType(): string
   {
        return CustomerAuthLogTypeEnum::loggedOut()->id();
   }


}
