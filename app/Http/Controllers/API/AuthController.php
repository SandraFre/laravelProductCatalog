<?php

namespace App\Http\Controllers\API;

use App\DTO\CustomerDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Responses\ApiResponse;
use App\User;
use Exception;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Token;

class AuthController extends Controller
{

    private $loginAfterSignUp = true;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(RegisterRequest $request):JsonResponse
    {
        try {
            User::query()->create($request->getRegisterData());
        } catch (Exception $exception) {
            return (new ApiResponse())->exception($exception->getMessage());
        }

        if ($this->loginAfterSignUp){
           return $this->login($request);
        }

        return (new ApiResponse())->success();
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->getCredentials();

        if (!$token = JWTAuth::attempt($credentials)) {
            return (new ApiResponse())->unauthorized('Invalid credentials');
        }

        return (new ApiResponse())->success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTFactory::getTTL() * 60,
        ]);
    }

    public function logout(): JsonResponse
    {
        try {
            $token = request()->bearerToken();


            auth()->invalidate($token);

            return (new ApiResponse())->success();
        } catch (JWTException $exception) {
            return (new ApiResponse())->exception($exception->getMessage());
        }
    }

    public function refresh()
    {
        $token = auth()->refresh();

        return (new ApiResponse())->success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTFactory::getTTL() * 60,
        ]);;
    }


    public function me(): JsonResponse
    {
        $user = auth()->user();

        return (new ApiResponse())->success(new CustomerDTO($user));
    }
}
