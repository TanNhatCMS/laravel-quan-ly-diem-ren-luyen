<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationsRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:255',
            'type' => 'nullable|string|in:department,faculty',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name' => 'Tên tổ chức',
            'type' => 'Loại tổ chức',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên tổ chức không được để trống.',
            'name.string' => 'Tên tổ chức phải là chuỗi ký tự.',
            'name.min' => 'Tên tổ chức phải có ít nhất 2 ký tự.',
            'name.max' => 'Tên tổ chức không được vượt quá 255 ký tự.',
            'type.string' => 'Loại tổ chức phải là chuỗi ký tự.',
            'type.in' => 'Loại tổ chức phải là phòng ban hoặc khoa.',
        ];
    }
}
