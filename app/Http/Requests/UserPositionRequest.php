<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPositionRequest extends FormRequest
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
        return [
            'user' => 'required|exists:users,id',
            'position' => 'required|exists:positions,id',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'user' => 'Người dùng',
            'position' => 'Chức vụ',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'user.required' => 'Người dùng không được để trống.',
            'user.exists' => 'Người dùng được chọn không tồn tại.',
            'position.required' => 'Chức vụ không được để trống.',
            'position.exists' => 'Chức vụ được chọn không tồn tại.',
        ];
    }
}
