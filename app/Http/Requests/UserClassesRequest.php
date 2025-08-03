<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserClassesRequest extends FormRequest
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
            'class_id' => 'required|integer|exists:classes,id',
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
            'class_id' => 'Lớp học',
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
            'class_id.required' => 'Lớp học không được để trống.',
            'class_id.integer' => 'Lớp học phải là số nguyên.',
            'class_id.exists' => 'Lớp học được chọn không tồn tại.',
        ];
    }
}
