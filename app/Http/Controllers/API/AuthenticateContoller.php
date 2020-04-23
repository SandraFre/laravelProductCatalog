<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Http\Responses\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthenticateContoller extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            if (!auth()->attempt($request->getCredentials())) {
                return (new ApiResponse())->unauthorized('Invalid credentials');
            }

            $customer = auth('sanctum')->user();
            $token = $customer->createToken($request->getDeviceName())->plainTextToken;

            return (new ApiResponse())->success([
                'token' => $token,
                'token_type' => 'bearer',
            ]);
        } catch (Exception $exception) {
            return (new ApiResponse())->exception($exception->getMessage());
        }
    }
}
