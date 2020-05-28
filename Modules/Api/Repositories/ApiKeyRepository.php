<?php

declare(strict_types=1);

namespace Modules\Api\Repositories;

use Modules\Api\Entities\ApiKey;
use Modules\Core\Repositories\Repository;

class ApiKeyRepository extends Repository
{
    public function model(): string
    {
       return ApiKey::class;
    }
}
