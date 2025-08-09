<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LecturersRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'academic_degree_id' => 'nullable|integer|exists:academic_degrees,id',
            'organization_id' => 'nullable|integer|exists:organizations,id',
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
            'name' => 'Tên giảng viên',
            'email' => 'Email',
            'academic_degree_id' => 'Học vị',
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
            'name.required' => 'Tên giảng viên không được để trống.',
            'name.string' => 'Tên giảng viên phải là chuỗi ký tự.',
            'name.min' => 'Tên giảng viên phải có ít nhất 2 ký tự.',
            'name.max' => 'Tên giảng viên không được vượt quá 255 ký tự.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email phải đúng định dạng.',
            'email.unique' => 'Email này đã tồn tại.',
            'academic_degree_id.integer' => 'Học vị phải là số nguyên.',
            'academic_degree_id.exists' => 'Học vị được chọn không tồn tại.',
            'organization_id.integer' => 'Tổ chức phải là số nguyên.',
            'organization_id.exists' => 'Tổ chức được chọn không tồn tại.',
        ];
    }
}
