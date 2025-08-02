<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * Show Users List.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $request->validate([
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $perPage = $request->per_page ?? 10;
        $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at'])
            ->with('roles:id,name')
            ->paginate($perPage);

        return $this->successResponse($users);
    }

    /**
     * Store User Information.
     *
     * @param  UserRequest  $request
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'nullable|array',
            'role.*' => 'string|exists:roles,name',
        ]);

        try {
            // store user information
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            if ($user && $request->has('role')) {
                $user->syncRoles($request->role);
            }

            return $this->successResponse([
                'message' => 'User created successfully!',
                'user_id' => $user->id,
            ]);
        } catch (\Exception $e) {
            return $this->failedResponse('Failed to create user: '.$e->getMessage());
        }
    }

    /**
     * Show User Profile.
     *
     * @param  int  $id
     * @param  Request  $request
     * @return JsonResponse
     */
    public function profile($id, Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'integer|min:1',
        ]);

        $user = User::select(['id', 'name', 'email', 'created_at', 'updated_at'])
            ->with(['roles:id,name', 'permissions:id,name'])
            ->find($id);

        if (! $user) {
            return $this->failedResponse('User not found!', 404);
        }

        return $this->successResponse($user);
    }

    /**
     * Delete User.
     *
     * @param  int  $id
     * @param  Request  $request
     * @return JsonResponse
     */
    public function delete($id, Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'integer|min:1',
        ]);

        $user = User::find($id);

        if (! $user) {
            return $this->failedResponse('User not found!', 404);
        }

        // Prevent deletion of current authenticated user
        if (auth()->user() && auth()->user()->id == $id) {
            return $this->failedResponse('Cannot delete your own account', 403);
        }

        try {
            $user->delete();

            return $this->successResponse([
                'message' => 'User has been deleted successfully',
            ]);
        } catch (\Exception $e) {
            return $this->failedResponse('Failed to delete user: '.$e->getMessage());
        }
    }

    /**
     * Change User Role.
     *
     * @param  int  $id
     * @param  Request  $request
     * @return JsonResponse
     */
    public function changeRole($id, Request $request): JsonResponse
    {
        $request->validate([
            'roles' => 'required|array|min:1',
            'roles.*' => 'string|exists:roles,name',
        ]);

        $user = User::find($id);

        if (! $user) {
            return $this->failedResponse('User not found!', 404);
        }

        try {
            // assign role to user
            $user->syncRoles($request->roles);

            return $this->successResponse([
                'message' => 'User roles have been updated successfully!',
                'roles' => $user->getRoleNames(),
            ]);
        } catch (\Exception $e) {
            return $this->failedResponse('Failed to update user roles: '.$e->getMessage());
        }
    }
}
