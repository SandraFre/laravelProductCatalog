<?php

declare(strict_types=1);

namespace Modules\Product\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Modules\Core\Responses\ApiResponse;
use Modules\Product\Services\CategoryService;
use Modules\Product\Services\ProductService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{

    private $categoryService;

    private $productService;

    public function __construct(CategoryService $categoryService, ProductService $productService)
    {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $categoryDTO = $this->categoryService->getAllForApi();
            return (new ApiResponse())->success($categoryDTO);
        } catch (\Throwable $exception) {
            logger()->error($exception->getMessage());

            return (new ApiResponse())->exception();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        try {
            $categoryDTO = $this->productService->getPaginateByCategorySlugForApi($slug);

            return (new ApiResponse())->success($categoryDTO);
        } catch (ModelNotFoundException $exception) {
            return (new ApiResponse())->modelNotFound();
        } catch (\Throwable $exception) {
            logger()->error($exception->getMessage());

            return (new ApiResponse())->exception();
        }
    }
}
