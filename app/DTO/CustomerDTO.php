<?php

declare(strict_types=1);

namespace App\DTO;

use App\DTO\Abstracts\DTO;
use App\User;

/**
 * Class CategoryDTO
 * @package App\DTO
 */
class CustomerDTO extends DTO
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    protected function jsonData(): array
    {
        return [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'created' => $this->user->created_at,
            'updated' => $this->user->updated_at,
        ];
    }
}
