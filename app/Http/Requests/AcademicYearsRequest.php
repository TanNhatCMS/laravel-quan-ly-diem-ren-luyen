<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcademicYearsRequest extends FormRequest
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
            'year' => 'required|string|regex:/^[0-9]{4}-[0-9]{4}$/|max:255',
            'name' => 'nullable|string|max:255',
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
            'year' => 'Năm học',
            'name' => 'Tên năm học',
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
            'year.required' => 'Năm học không được để trống.',
            'year.string' => 'Năm học phải là chuỗi ký tự.',
            'year.regex' => 'Năm học phải có định dạng YYYY-YYYY (ví dụ: 2024-2025).',
            'year.max' => 'Năm học không được vượt quá 255 ký tự.',
            'name.string' => 'Tên năm học phải là chuỗi ký tự.',
            'name.max' => 'Tên năm học không được vượt quá 255 ký tự.',
        ];
    }
}
