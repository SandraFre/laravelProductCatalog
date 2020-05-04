<?php

declare(strict_types=1);

namespace Modules\Product\Services;

use App\DTO\Abstracts\CollectionDTO;
use App\DTO\Abstracts\PaginateLengthAwareDTO;
use Modules\Product\DTO\ProductDTO;
use Modules\Product\Entities\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductService
{
    public function getBySlugApi(string $slug): ProductDTO
    {
        $product = Product::query()
            ->where('active', '=', 1)
            ->where('slug', '=', $slug)
            ->firstOrFail();

        return new ProductDTO($product);
    }

    public function getAllForApi(): CollectionDTO
    {
        $productsDTO = new CollectionDTO();

        $products = Product::query()
            ->with(['images', 'categories'])
            ->where('active', '=', 1)
            ->get();

        foreach ($products as $product) {
            $productsDTO->pushItem(new ProductDTO($product));
        }

        return $productsDTO;
    }

    public function getpaginateForApi(): PaginateLengthAwareDTO
    {
        $productsDTO = new CollectionDTO();

        $products = Product::query()
            ->with(['images', 'categories'])
            ->where('active', '=', 1)
            ->paginate();

        foreach ($products as $product) {
            $productsDTO->pushItem(new ProductDTO($product));
        }


        return (new PaginateLengthAwareDTO($products))->setData($productsDTO);
    }

    public function getPaginateByCategorySlugForApi(string $slug): PaginateLengthAwareDTO
    {
        $productsDTO = new CollectionDTO();

        $products = Product::query()
            ->with(['images', 'categories'])
            ->where('active', '=', 1)
            ->whereHas('categories', function (Builder $query) use ($slug){
                $query->where('slug', '=', $slug);
            })
            ->paginate();

            foreach ($products as $product) {
                $productsDTO->pushItem(new ProductDTO($product));
            }

            return (new PaginateLengthAwareDTO($products))->setData($productsDTO);
    }
}
