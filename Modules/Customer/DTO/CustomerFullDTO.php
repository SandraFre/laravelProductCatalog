<?php

declare(strict_types=1);

namespace  Modules\Customer\DTO;

use Modules\Core\DTO\CollectionDTO;
use Modules\Core\DTO\DTO;
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
            'auth_log_list' => $this->getAuthLogs(),
        ];
    }

    private function getAuthLogs(): CollectionDTO
    {
        $collectionDTO = new CollectionDTO();

        $logs = $this->customer->authLogs;

        foreach ($logs as $log){
            $collectionDTO->pushItem(new CustomerAuthLogDTO($log));
        }

        return $collectionDTO;
    }

}
