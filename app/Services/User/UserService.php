<?php

namespace App\Services\User;

use App\Contracts\Services\UserServiceInterface;
use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\UserListQueryDTO;
use App\Exceptions\User\UserDeletionException;
use App\Exceptions\User\UserNotFoundException;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService implements UserServiceInterface
{
    /**
     * Get paginated users list.
     */
    public function list(UserListQueryDTO $query): LengthAwarePaginator
    {
        return User::select(['id', 'name', 'email', 'created_at', 'updated_at'])
            ->with('roles:id,name')
            ->paginate($query->perPage);
    }

    /**
     * Create a new user.
     */
    public function create(CreateUserDTO $userData): User
    {
        $user = User::create([
            'name' => $userData->name,
            'email' => $userData->email,
            'password' => bcrypt($userData->password),
        ]);

        if ($userData->roles) {
            $user->syncRoles($userData->roles);
        }

        return $user;
    }

    /**
     * Get user profile by ID.
     */
    public function profile(int $id): User
    {
        $user = User::select(['id', 'name', 'email', 'created_at', 'updated_at'])
            ->with(['roles:id,name', 'permissions:id,name'])
            ->find($id);

        if (! $user) {
            throw new UserNotFoundException("User with ID {$id} not found");
        }

        return $user;
    }

    /**
     * Delete user by ID.
     */
    public function delete(int $id): void
    {
        $user = User::find($id);

        if (! $user) {
            throw new UserNotFoundException("User with ID {$id} not found");
        }

        // Prevent deletion of current authenticated user
        if (auth('api')->user() && auth('api')->user()->id == $id) {
            throw new UserDeletionException('Cannot delete your own account');
        }

        $user->delete();
    }

    /**
     * Change user roles.
     */
    public function changeRole(int $id, array $roles): User
    {
        $user = User::find($id);

        if (! $user) {
            throw new UserNotFoundException("User with ID {$id} not found");
        }

        $user->syncRoles($roles);

        return $user;
    }
}
