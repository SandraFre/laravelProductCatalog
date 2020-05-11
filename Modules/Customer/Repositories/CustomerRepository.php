<?php

declare(strict_types=1);

namespace  Modules\Customer\Repositories;

use App\User;
use Modules\Core\Repositories\Repository;

class CustomerRepository extends Repository
{
    public function model(): string
    {
        return User::class;
    }
}
