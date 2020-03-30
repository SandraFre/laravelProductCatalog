<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        //SELECT * FROM products LIMITS 0, 15
        /** @var LengthAwarePaginator $products */
        $products = Product::query()->paginate();

        return view('product.product-list', [
            'list' => $products,
        ]);
    }

    public function create(): View
    {
        $categories = Category::query()->get();
        return view('product.create', [
            'categories'=>$categories,
        ]);
    }

    public function store(ProductStoreRequest $request): RedirectResponse
    {
        $data = $request->only(
            'title',
            'description',
            'price'
        );

        // $product = new Product();
        // $product->title =  $request->input('title');
        // $product->description =  $request->input('description');
        // $product->price =  $request->input('price');
        // $product->save();

        $catIds = $request->input('categories');

        $product = Product::query()->create($data);
        $product->categories()->sync($catIds);

        return redirect()->route('products.index');
    }

    public function edit(int $id): View
    {
        //SELECT * FROM products WHERE id = ?
        $product = Product::query()->find($id);
        $productCategoryIds = $product->categories()->pluck('id')->toArray();
        $categories = Category::query()->get();

        return view('product.edit', [
            'product' => $product,
            'categoryIds' => $productCategoryIds,
            'categories' => $categories,
        ]);
    }

    public function update(ProductUpdateRequest $request, Product $product): RedirectResponse
    {
        $data = $request->only('title', 'description', 'price');
        $catIds = $request->input('categories');

        // $product->title = $request->input('title');
        // $product->save();

        $product->update($data);
        $product->categories()->sync($catIds);

        return redirect()->route('products.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        //DELETE FROM products WHERE id = ?
        Product::query()
            ->where('id', '=', $id)
            ->delete();

        return redirect()->route('products.index');
    }
}
