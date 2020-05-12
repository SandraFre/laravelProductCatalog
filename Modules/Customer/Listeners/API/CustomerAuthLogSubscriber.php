<?php

declare(strict_types=1);

namespace Modules\Customer\Listeners\API;

use Modules\Customer\Events\API\CustomerLoginEvent;
use Modules\Customer\Events\API\CustomerLogoutEvent;
use Illuminate\Events\Dispatcher;

class CustomerAuthLogSubscriber
{
    public function subscribe(Dispatcher $event)
    {
        $event->listen(
            [
                CustomerLoginEvent::class,
                CustomerLogoutEvent::class,
            ],
            CustomerAuthLogListener::class
        );
    }
}
