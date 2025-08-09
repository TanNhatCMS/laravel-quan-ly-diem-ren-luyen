<?php

namespace App\Services\Auth;

use App\Contracts\Services\AuthServiceInterface;
use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\UserProfileDTO;
use App\Exceptions\Auth\InvalidCredentialsException;
use App\Exceptions\Auth\TokenException;
use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthService implements AuthServiceInterface
{
    /**
     * Authenticate user and generate JWT token.
     */
    public function login(LoginDTO $loginData): array
    {
        $credentials = [
            'email' => $loginData->email,
            'password' => $loginData->password,
        ];

        if (! $token = JWTAuth::attempt($credentials)) {
            throw new InvalidCredentialsException('Invalid credentials provided');
        }

        $user = JWTAuth::user();

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => $this->formatUserData($user),
        ];
    }

    /**
     * Get authenticated user profile.
     */
    public function profile(): UserProfileDTO
    {
        $user = auth('api')->user();

        if (! $user) {
            throw new TokenException('User not authenticated');
        }

        return new UserProfileDTO(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            roles: $user->getRoleNames()->toArray(),
            permissions: $user->getAllPermissions()->pluck('name')->toArray()
        );
    }

    /**
     * Logout user and invalidate token.
     */
    public function logout(): void
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (\Exception $e) {
            throw new TokenException('Failed to logout, token may be invalid');
        }
    }

    /**
     * Refresh JWT token.
     */
    public function refresh(): array
    {
        try {
            $token = JWTAuth::getToken();
            if (! $token) {
                throw new TokenException('Token not provided');
            }

            $newToken = JWTAuth::refresh($token);

            return [
                'access_token' => $newToken,
                'token_type' => 'Bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60,
            ];
        } catch (\Exception $e) {
            throw new TokenException('Token refresh failed');
        }
    }

    /**
     * Format user data for API response.
     */
    private function formatUserData(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->getRoleNames()->toArray(),
        ];
    }
}
