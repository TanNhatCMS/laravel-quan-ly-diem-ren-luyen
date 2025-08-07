<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\AuthServiceInterface;
use App\DTOs\Auth\LoginDTO;
use App\Exceptions\Auth\InvalidCredentialsException;
use App\Exceptions\Auth\TokenException;
use App\Services\Response\ApiResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function __construct(
        private readonly AuthServiceInterface $authService
    ) {}

    /**
     * Get a JWT via given credentials.
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|max:255',
        ]);

        try {
            $loginData = LoginDTO::fromRequest($request->all());
            $result = $this->authService->login($loginData);

            return ApiResponseService::success($result);
        } catch (InvalidCredentialsException $e) {
            return ApiResponseService::unauthorized($e->getMessage());
        }
    }

    /**
     * Get the authenticated User.
     */
    public function profile(): JsonResponse
    {
        try {
            $profile = $this->authService->profile();

            return ApiResponseService::success($profile->toArray());
        } catch (TokenException $e) {
            return ApiResponseService::unauthorized($e->getMessage());
        }
    }

    /**
     * Log the user out (Invalidate the token).
     */
    public function logout(): JsonResponse
    {
        try {
            $this->authService->logout();

            return ApiResponseService::success(
                message: 'Logged out successfully'
            );
        } catch (TokenException $e) {
            return ApiResponseService::error($e->getMessage(), null, 400);
        }
    }

    /**
     * Refresh a token.
     */
    public function refresh(): JsonResponse
    {
        try {
            $result = $this->authService->refresh();

            return ApiResponseService::success($result);
        } catch (TokenException $e) {
            return ApiResponseService::unauthorized($e->getMessage());
        }
    }
}
