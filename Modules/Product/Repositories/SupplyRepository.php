<?php
declare(strict_types=1);

namespace Modules\Product\Repositories;

use Modules\Core\Repositories\Repository;
use Modules\Product\Entities\Supply;

class SupplyRepository extends Repository
{
 public function model(): string
 {
    return Supply::class;
 }
}
