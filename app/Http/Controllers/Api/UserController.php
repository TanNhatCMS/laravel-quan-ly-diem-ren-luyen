<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\UserServiceInterface;
use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\UserListQueryDTO;
use App\Exceptions\User\UserDeletionException;
use App\Exceptions\User\UserNotFoundException;
use App\Http\Requests\UserRequest;
use App\Services\Response\ApiResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function __construct(
        private readonly UserServiceInterface $userService
    ) {
    }

    /**
     * Show Users List.
     */
    public function list(Request $request): JsonResponse
    {
        $request->validate([
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $query = UserListQueryDTO::fromRequest($request->all());
        $users = $this->userService->list($query);

        return ApiResponseService::success($users);
    }

    /**
     * Store User Information.
     */
    public function store(UserRequest $request): JsonResponse
    {
        try {
            $userData = CreateUserDTO::fromRequest($request->validated());
            $user = $this->userService->create($userData);

            return ApiResponseService::success([
                'message' => 'User created successfully!',
                'user_id' => $user->id,
            ]);
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to create user: '.$e->getMessage());
        }
    }

    /**
     * Show User Profile.
     */
    public function profile($id, Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'integer|min:1',
        ]);

        try {
            $user = $this->userService->profile((int) $id);

            return ApiResponseService::success($user);
        } catch (UserNotFoundException $e) {
            return ApiResponseService::notFound($e->getMessage());
        }
    }

    /**
     * Delete User.
     */
    public function delete($id, Request $request): JsonResponse
    {
        // Validate ID parameter
        if (! is_numeric($id) || $id < 1) {
            return ApiResponseService::error('Invalid user ID', null, 400);
        }

        try {
            $this->userService->delete((int) $id);

            return ApiResponseService::success([
                'message' => 'User has been deleted successfully',
            ]);
        } catch (UserNotFoundException $e) {
            return ApiResponseService::notFound($e->getMessage());
        } catch (UserDeletionException $e) {
            return ApiResponseService::forbidden($e->getMessage());
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to delete user: '.$e->getMessage());
        }
    }

    /**
     * Change User Role.
     */
    public function changeRole($id, Request $request): JsonResponse
    {
        $request->validate([
            'roles' => 'required|array|min:1',
            'roles.*' => 'string|exists:roles,name',
        ]);

        try {
            $user = $this->userService->changeRole((int) $id, $request->roles);

            return ApiResponseService::success([
                'message' => 'User roles have been updated successfully!',
                'roles' => $user->getRoleNames(),
            ]);
        } catch (UserNotFoundException $e) {
            return ApiResponseService::notFound($e->getMessage());
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to update user roles: '.$e->getMessage());
        }
    }
}
