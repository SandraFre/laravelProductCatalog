<?php

declare(strict_types=1);

namespace App\Services;

use App\Category;
use App\DTO\Abstracts\CollectionDTO;
use App\DTO\CategoryDTO;

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
        $category = Category::query()->where('slug', '=', $slug)
            ->firstOrFail();

        return new CategoryDTO($category);
    }
}
