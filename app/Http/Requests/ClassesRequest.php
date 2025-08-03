<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassesRequest extends FormRequest
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
            'organization_id' => 'required|integer|exists:organizations,id',
            'major_id' => 'required|integer|exists:majors,id',
            'course_id' => 'required|integer|exists:courses,id',
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
            'name' => 'Tên lớp',
            'organization_id' => 'Tổ chức',
            'major_id' => 'Ngành học',
            'course_id' => 'Khóa học',
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
            'name.required' => 'Tên lớp không được để trống.',
            'name.string' => 'Tên lớp phải là chuỗi ký tự.',
            'name.min' => 'Tên lớp phải có ít nhất 2 ký tự.',
            'name.max' => 'Tên lớp không được vượt quá 255 ký tự.',
            'organization_id.required' => 'Tổ chức không được để trống.',
            'organization_id.integer' => 'Tổ chức phải là số nguyên.',
            'organization_id.exists' => 'Tổ chức được chọn không tồn tại.',
            'major_id.required' => 'Ngành học không được để trống.',
            'major_id.integer' => 'Ngành học phải là số nguyên.',
            'major_id.exists' => 'Ngành học được chọn không tồn tại.',
            'course_id.required' => 'Khóa học không được để trống.',
            'course_id.integer' => 'Khóa học phải là số nguyên.',
            'course_id.exists' => 'Khóa học được chọn không tồn tại.',
        ];
    }
}
