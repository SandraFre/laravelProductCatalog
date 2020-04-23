<?php

declare(strict_types=1);

namespace App\DTO;

use App\DTO\Abstracts\DTO;
use App\User;

class CustomerMiniDTO extends DTO
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function jsonData():array
    {
        return  [
            'name'=> $this->user->name,
            'email'=> $this->user->email,
        ];
    }

}
