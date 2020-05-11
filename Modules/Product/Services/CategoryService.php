<?php

declare(strict_types=1);

namespace Modules\Product\Services;

use Modules\Product\Entities\Category;
use Modules\Core\DTO\CollectionDTO;
use Modules\Product\DTO\CategoryDTO;

class CategoryService
{
    public function getAllForApi(): CollectionDTO
    {
        $categoryDTO = new CollectionDTO();

        $data = Category::query()->get();

        foreach ($data as $item) {
            $categoryDTO->pushItem(new CategoryDTO($item));
        }

        return $categoryDTO;
    }

    public function getBySlugForApi(string $slug): CategoryDTO
    {
        $category = Category::query()
            ->where('slug', '=', $slug)
            ->firstOrFail();

        return new CategoryDTO($category);
    }
}
