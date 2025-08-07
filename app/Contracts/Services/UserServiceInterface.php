<?php

namespace App\Contracts\Services;

use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\UserListQueryDTO;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserServiceInterface
{
    public function list(UserListQueryDTO $query): LengthAwarePaginator;
    
    public function create(CreateUserDTO $userData): User;
    
    public function profile(int $id): User;
    
    public function delete(int $id): void;
    
    public function changeRole(int $id, array $roles): User;
}