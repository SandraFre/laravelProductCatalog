<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Product;
use App\ProductImage;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;

/**
 * Class ProductController
 *
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        // SELECT * FROM products LIMITS 15, 30
        /** @var LengthAwarePaginator $products */
        $products = Product::query()->with(['images', 'categories'])
            ->paginate();
        return view('product.product-list', [
            'list' => $products,
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        /** @var Collection|Category[] $categories */
        $categories = Category::query()->get();

        return view('product.form', [
            'categories' => $categories,
        ]);
    }

    /**
     * @param ProductStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function store(ProductStoreRequest $request): RedirectResponse
    {
        $data = $request->getData();

        $catIds = $request->getCategories();

        /** @var Product $product */
        $product = Product::query()->create($data);
        $product->categories()->sync($catIds);

        if ($uploadedFile = $request->getImage()) {
            $imagePath = $uploadedFile->store('products');
            $productImage = new ProductImage(['file' => $imagePath]);
            $product->images()->save($productImage);
        }

        return redirect()->route('products.index');
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function edit(int $id): View
    {
        // SELECT * FROM products WHERE id = ?
        /** @var Product $product */
        $product = Product::query()->find($id);
        $productCategoryIds = $product->categories()->pluck('id')->toArray();
        /** @var Category $categories */
        $categories = Category::query()->get();

        return view('product.form', [
            'product' => $product,
            'categoryIds' => $productCategoryIds,
            'categories' => $categories,
        ]);
    }

    /**
     * @param ProductUpdateRequest $request
     * @param Product $product
     *
     * @return RedirectResponse
     */
    public function update(ProductUpdateRequest $request, Product $product): RedirectResponse
    {
        $data = $request->getData();
        $catIds = $request->getCategories();

        $product->update($data);
        $product->categories()->sync($catIds);

        return redirect()->route('products.index');
    }

    /**
     * @param int $id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(int $id): RedirectResponse
    {
        // DELETE FROM products WHERE id = ?
        Product::query()
            ->where('id', '=', $id)
            ->delete();

        return redirect()->route('products.index');
    }

}
