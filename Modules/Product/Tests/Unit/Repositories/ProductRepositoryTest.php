<?php

declare(strict_types=1);

namespace Modules\Product\Tests\Unit\Repositories;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Repositories\ProductRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @group product
     * @group repository
     *
     * @throws BindingResolutionException
     */
    public function testPaginateWithRelationsReturnLengthAwarePaginatorInstance(): void
    {
        $result = $this->getTestClassInstance()->paginateWithRelations();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    /**
     * @group product
     * @group repository
     *
     * @throws BindingResolutionException
     */
    public function testPaginateWithRelationsReturnWithRelations(): void
    {
        $count = 5;
        factory(Product::class, $count)->create();

        /** @var LengthAwarePaginator|Product[] $products */
        $products = $this->getTestClassInstance()->paginateWithRelations(['categories']);

        foreach ($products as $product) {
            $this->assertTrue($product->relationLoaded('categories'));
        }

        $this->assertCount($count, $products);
    }

    /**
     * @group product
     * @group repository
     *
     * @throws BindingResolutionException
     */
    public function testPaginateWithRelationsReturnOnlyActive(): void
    {
        $activeCount = 3;
        $unActiveCount = 2;

        factory(Product::class, $activeCount)->create([
            'active' => true,
        ]);

        factory(Product::class, $unActiveCount)->create([
            'active' => false,
        ]);

        /** @var LengthAwarePaginator|Product[] $products */
        $products = $this->getTestClassInstance()->paginateWithRelations([], true);

        $this->assertCount($activeCount, $products);

        foreach ($products as $product) {
            $this->assertTrue($product->active);
        }
    }

    /**
     * @group product
     * @group repository
     *
     * @throws BindingResolutionException
     */
    public function testGetByCategorySlugReturnLengthAwarePaginatorInstance(): void
    {
        $slug = $this->faker->slug;

        $result = $this->getTestClassInstance()->getByCategorySlug($slug);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    /**
     * @group product
     * @group repository
     *
     * @throws BindingResolutionException
     */
    public function testGetByCategorySlugReturnProducts(): void
    {
        $productCount = 3;

        /** @var Category $category */
        $category = factory(Category::class)->create();

        /** @var Category $otherCategory */
        $otherCategory = factory(Category::class)->create();

        $productIds = factory(Product::class, $productCount)
            ->create(['active' => true])
            ->each(function (Product $product) use ($category) {
                $product->categories()->attach([$category->id]);
            })
            ->pluck('id')->toArray();

        factory(Product::class, $productCount)
            ->create(['active' => true])
            ->each(function (Product $product) use ($otherCategory) {
                $product->categories()->attach([$otherCategory->id]);
            });

        /** @var LengthAwarePaginator|Product[] $products */
        $products = $this->getTestClassInstance()->getByCategorySlug($category->slug);

        $this->assertCount($productCount, $products);

        foreach ($products as $product) {
            $this->assertTrue($product->relationLoaded('images'));
            $this->assertTrue($product->relationLoaded('categories'));
            $this->assertTrue($product->relationLoaded('suppliers'));

            $this->assertTrue(in_array($product->id, $productIds));
        }
    }

    /**
     * @group product
     * @group repository
     *
     * @throws BindingResolutionException
     */
    public function testFailGetBySlug(): void
    {
        $slug = $this->faker->slug;

        $this->expectException(ModelNotFoundException::class);

        $this->getTestClassInstance()->getBySlug($slug);
    }

    /**
     * @group product
     * @group repository
     *
     * @throws BindingResolutionException
     */
    public function testSuccessGetBySlug(): void
    {
        factory(Product::class)->create();

        /** @var Product $product */
        $product = factory(Product::class, 3)
            ->create(['active' => true])
            ->first();

        /** @var Product $result */
        $result = $this->getTestClassInstance()->getBySlug($product->slug);

        $this->assertInstanceOf(Product::class, $result);

        $this->assertEquals($product->id, $result->id, 'Product IDs');
        $this->assertEquals($product->title, $result->title);
        $this->assertEquals($product->slug, $result->slug);
        $this->assertEquals($product->active, $result->active);
    }

    /**
     * @group product
     * @group repository
     *
     * @throws BindingResolutionException
     */
    public function testCreateWithRelations(): void
    {
        /** @var Collection|Category[] $categories */
        $categories = factory(Category::class, 2)->create();

        $productData = factory(Product::class)->make()
            ->toArray();

        $categoryIds = $categories->pluck('id')->toArray();

        $relatedData = [
            'categories' => $categoryIds,
        ];

        $result = $this->getTestClassInstance()->createWithManyToManyRelations(
            $productData,
            $relatedData
        );

        $this->assertInstanceOf(Product::class, $result);
        $this->assertDatabaseHas('products', $productData);
        $this->assertEquals($categoryIds, $result->categories->pluck('id')->toArray());
    }

    /**
     * @group product
     * @group repository
     *
     * @throws BindingResolutionException
     */
    public function testUpdateWithManyToManyRelations(): void
    {
        $updatedTitle = 'Updated Product';

        $category1 = factory(Category::class)->create();
        $category2 = factory(Category::class)->create();

        $product = factory(Product::class)->create([
            'title' => 'Test Product'
        ]);
        $product->categories()->attach([$category1->id]);

        $result = $this->getTestClassInstance()->updateWithManyToManyRelations($product->id, [
            'title' => $updatedTitle
        ], [
            'categories' => [$category2->id],
        ]);

        $this->assertInstanceOf(Product::class, $result);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title' => $updatedTitle,
        ]);

        $this->assertEquals([$category2->id], $result->categories->pluck('id')->toArray());
    }

    /**
     * @return ProductRepository
     * @throws BindingResolutionException
     */
    private function getTestClassInstance(): ProductRepository
    {
        return $this->app->make(ProductRepository::class);
    }
}
