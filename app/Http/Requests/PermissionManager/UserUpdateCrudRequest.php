<?php

namespace App\Http\Requests\PermissionManager;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateCrudRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $id = $this->get('id') ?? request()->route('id');

        return [
            'email' => 'required|unique:'.config('backpack.permissionmanager.models.user', 'users').',email,'.$id,
            'name' => 'required',
            'password' => 'confirmed',
        ];
    }
}
