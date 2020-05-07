<?php

namespace Modules\Customer\Http\Controllers\API;

use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
        /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Request $request): JsonResponse
    {
        return (new ApiResponse())->success(Auth::user());
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
