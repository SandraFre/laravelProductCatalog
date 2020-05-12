<?php

namespace Modules\Customer\Events\API\Abstracts;

use Modules\Customer\Events\API\Contracts\CustomerAuthContract;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable as EventsDispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

abstract class CustomerAuthAbstract implements CustomerAuthContract
{
    use EventsDispatchable, InteractsWithSockets, SerializesModels;

    public $customer;
    public $tokenId;
    public $eventTime;

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

    abstract public function getType(): string;

}
