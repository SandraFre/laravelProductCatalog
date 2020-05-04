<?php
declare(strict_types=1);

namespace Modules\Product\Repositories;

use Modules\Core\Repositories\Repository;
use Modules\Product\Entities\Category;

class CategoryRepository extends Repository
{
 public function model(): string
 {
    return Category::class;
 }
}
