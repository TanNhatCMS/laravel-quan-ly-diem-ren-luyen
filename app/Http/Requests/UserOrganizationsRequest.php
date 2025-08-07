<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserOrganizationsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'organization_id' => 'required|integer|exists:organizations,id',
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
            'user_id' => 'Người dùng',
            'organization_id' => 'Tổ chức',
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
            'user_id.required' => 'Người dùng không được để trống.',
            'user_id.integer' => 'Người dùng phải là số nguyên.',
            'user_id.exists' => 'Người dùng được chọn không tồn tại.',
            'organization_id.required' => 'Tổ chức không được để trống.',
            'organization_id.integer' => 'Tổ chức phải là số nguyên.',
            'organization_id.exists' => 'Tổ chức được chọn không tồn tại.',
        ];
    }
}
