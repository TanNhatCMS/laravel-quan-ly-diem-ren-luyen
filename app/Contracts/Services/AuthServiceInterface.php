<?php

namespace App\Contracts\Services;

use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\UserProfileDTO;

interface AuthServiceInterface
{
    public function login(LoginDTO $loginData): array;
    
    public function profile(): UserProfileDTO;
    
    public function logout(): void;
    
    public function refresh(): array;
}