<?php

declare(strict_types=1);

namespace Modules\Customer\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Customer\Listeners\API\CustomerAuthLogSubscriber;

class EventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        CustomerAuthLogSubscriber::class
    ];
}
