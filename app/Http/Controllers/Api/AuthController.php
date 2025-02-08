<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends BaseController
{
    /**
     * Register a User.
     *
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['user'] = $user;

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

        $success = $this->respondWithToken($token);

        return $this->sendResponse($success, 'User login successfully.');
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function profile()
    {
        if ($user = auth()->user()) {
            $roles = $user->getRoleNames();
            $permission = $user->getAllPermissions();

            return $this->sendResponse($user, 'Refresh token return successfully.');
        }

        return $this->failedResponse();
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        $user = auth()->user()->token();
        $user->revoke();
        auth()->logout();
        return $this->sendResponse([], 'Successfully logged out.');
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        $success = $this->respondWithToken(auth()->refresh());

        return $this->sendResponse($success, 'Refresh token return successfully.');
    }

    /**
     * Get the token array structure.
     *
     * @param  string  $token
     * @return array
     */
    protected function respondWithToken(string $token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];
    }

//    public function changePassword(PasswordChangeRequest $request): JsonResponse
//    {
//        $user = auth()->user();
//        if ($user && Hash::check($request->old_password, $user->password)) {
//            User::find($user->id)
//                ->update([
//                    'password' => Hash::make($request->password),
//                ]);
//
//            return $this->successResponse([
//                'message' => 'Password has been changed',
//            ]);
//        }
//
//        return $this->failedResponse();
//    }
//
//    public function updateProfile(ProfileUpdateRequest $request): JsonResponse
//    {
//        $user = auth()->user();
//        // check unique email except this user
//        if (isset($request->email)) {
//            $check = User::where('email', $request->email)
//                ->where('id', '!=', $user->id)
//                ->first();
//
//            if ($check) {
//                return $this->failedResponse('The email address is already used!');
//            }
//        }
//
//        $user->update(
//            $request->only([
//                'name',
//                'email',
//            ])
//        );
//
//        return $this->successResponse([
//            'message' => 'Profile updated successfully!',
//        ]);
//    }
}
