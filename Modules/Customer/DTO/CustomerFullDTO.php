<?php

declare(strict_types=1);

namespace  Modules\Customer\DTO;

use App\DTO\Abstracts\DTO;
use App\User;

class CustomerFullDTO extends DTO
{

    private User $customer;

    public function __construct(User $customer) {
        $this->customer = $customer;
    }


    protected function jsonData(): array
    {
        return [
            'first_name' => $this->customer->name,
            'last_name'=> $this->customer->last_name,
            'email'=> $this->customer->email,
            'mobile'=> $this->customer->mobile,
            'address'=> $this->customer->address,
        ];
    }

}
