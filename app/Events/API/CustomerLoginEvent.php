<?php

declare(strict_types=1);

namespace App\Events\API;

use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class CustomerLoginEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $customer;
    public $tokenId;
    public $eventTime;
    public $type = 'logged_in';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $customer, string $tokenId, Carbon $eventTime)
    {
        $this->customer = $customer;
        $this->tokenId = $tokenId;
        $this->eventTime = $eventTime;
    }


}
