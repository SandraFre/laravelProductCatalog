<?php

declare(strict_types=1);

namespace App\Listeners\API;

use App\Events\API\CustomerLoginEvent;
use App\UserAuthLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CustomerAuthLogListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CustomerLoginEvent $event): void
    {
        UserAuthLog::query()->create([
            'user_id' => $event->customer->id,
            'token_id' => $event->tokenId,
            'event_time' => $event->eventTime,
            'type' => $event->type,
        ]);
    }
}
