<?php

declare(strict_types=1);

namespace  Modules\Customer\DTO;

use Modules\Core\DTO\DTO;
use App\User;

class CustomerDTO extends DTO
{
    public function __construct(User $customer) {
        $this->customer = $customer;
    }

    protected function jsonData(): array
    {
        return[
        'name' => $this->customer->name,
        'email' => $this->customer->email,

        ];
    }

}
