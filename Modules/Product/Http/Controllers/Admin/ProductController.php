<?php

declare(strict_types=1);

namespace Modules\Product\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Product\Entities\Category;
use Modules\Product\Enum\ProductTypeEnum;
use Modules\Product\Entities\Supply;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductImage;
use Modules\Product\Http\Requests\ProductStoreRequest;
use Modules\Product\Http\Requests\ProductUpdateRequest;
use Modules\Product\Repositories\CategoryRepository;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Repositories\SupplyRepository;
use Modules\Product\Services\ImagesManager;

class ProductController extends Controller
{
    private $productRepository;
    private $categoryRepository;
    private $supplyRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository, SupplyRepository $supplyRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->supplyRepository = $supplyRepository;
    }


    /**
     * @return View
     */
    public function index(): View
    {
        /** @var LengthAwarePaginator $products */
        $products = $this->productRepository
            ->paginateWithRelations(['images', 'categories']);

        return view('product::product.list', [
            'list' => $products,
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        /** @var Collection|Category[] $categories */
        $categories = $this->categoryRepository->all(['id', 'title']);

        $suppliers = $this->supplyRepository->pluck('title', 'id');

        $types = ProductTypeEnum::enum();

        return view('product::product.form', [
            'categories' => $categories,
            'suppliers' => $suppliers,
            'types' => $types,
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
        $suppliersIds = $request->getSuppliers();

        /** @var Product $product */
        $product = $this->productRepository->create($data);
        $product->categories()->sync($catIds);
        $product->suppliers()->sync($suppliersIds);

        ImagesManager::saveMany(
            $product,
            $request->getImages(),
            ProductImage::class,
            'file',
            ImagesManager::PATH_PRODUCT
        );

        return redirect()->route('products.index')
            ->with('status', 'Product created');
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function edit(int $id): View
    {
        /** @var Product $product */
        $product = $this->productRepository->find($id);
        $productCategoryIds = $product->categories()->pluck('id')->toArray();
        $productSupplierIds = $product->suppliers()->pluck('id')->toArray();
        /** @var Category $categories */
        $categories = $this->categoryRepository->all(['id', 'title']);

        $suppliers = $this->supplyRepository->pluck('title', 'id');

        $types = ProductTypeEnum::enum();

        return view('product::product.form', [
            'product' => $product,
            'categoryIds' => $productCategoryIds,
            'supplierIds' => $productSupplierIds,
            'categories' => $categories,
            'suppliers' => $suppliers,
            'types' => $types,
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
        $suppliersIds = $request->getSuppliers();

        $this->productRepository->update($data, $product->id);
        $product->categories()->sync($catIds);
        $product->suppliers()->sync($suppliersIds);

        ImagesManager::saveMany(
            $product,
            $request->getImages(),
            ProductImage::class,
            'file',
            ImagesManager::PATH_PRODUCT,
            $request->getDeleteImages()
        );

        return redirect()->route('products.index')
            ->with('status', 'Product updated.');
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Product $product): RedirectResponse
    {
        Storage::delete(
            $product->images->pluck('file')->toArray()
        );

        $this->productRepository->delete($product->id);

        return redirect()->route('products.index')
            ->with('status', 'Product deleted.');
    }
}
