<?php
declare(strict_types=1);

namespace Modules\Product\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Modules\Core\Responses\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Modules\Product\Services\ProductService;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        try {
            $productsDTO = $this->productService->getPaginateForApi();
            return(new ApiResponse())->success($productsDTO);
        } catch (\Throwable $exception) {
            logger()->error($exception->getMessage());

            return (new ApiResponse())->exception();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug): JsonResponse
    {
        try {
            $productDTO = $this->productService->getBySlugForApi($slug);

            return(new ApiResponse())->success($productDTO);
                } catch (ModelNotFoundException $exception) {
                    return (new ApiResponse())->modelNotFound();
        } catch (\Throwable $exception) {
            logger()->error($exception->getMessage());

            return (new ApiResponse())->exception($exception->getMessage());
        }
    }
}
