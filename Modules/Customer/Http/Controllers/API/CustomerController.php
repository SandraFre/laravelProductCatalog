<?php

namespace Modules\Customer\Http\Controllers\API;

use Modules\Core\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Customer\DTO\CustomerFullDTO;
use Modules\Customer\Http\Requests\API\CustomerUpdateRequest;
use Modules\Customer\Services\CustomerService;
use Throwable;

class CustomerController extends Controller
{

    private CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(): JsonResponse
    {
        try {
            $customerDTO = $this->customerService->getMyInfoAPi();
            return (new ApiResponse())->success($customerDTO);
        } catch (Throwable $exception) {
            return (new ApiResponse())->exception($exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CustomerUpdateRequest $request): JsonResponse
    {
        try {
            $this->customerService->updateMyInfoApi($request->getData());
        } catch (Throwable $exception) {
            return (new ApiResponse())->exception($exception->getMessage());
        }

        return (new ApiResponse())->success();
    }


    public function destroy(): JsonResponse
    {
        try {
            $this->customerService->deleteMe();
        } catch (Throwable $exception) {
            return (new ApiResponse())->exception($exception->getMessage());
        }
        return (new ApiResponse())->success();
    }
}
