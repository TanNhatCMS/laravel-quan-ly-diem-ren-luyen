<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SemesterScoresRequest extends FormRequest
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
            'year' => 'required|string|max:255|regex:/^[0-9]{4}-[0-9]{4}$/',
            'semester' => 'required|in:Học Kỳ 1,Học Kỳ 2,Học Kỳ 3',
            'evaluation_start' => 'required|date',
            'evaluation_end' => 'required|date|after:evaluation_start',
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
            'semester' => 'Học kỳ',
            'evaluation_start' => 'Ngày bắt đầu đánh giá',
            'evaluation_end' => 'Ngày kết thúc đánh giá',
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
            'year.max' => 'Năm học không được vượt quá 255 ký tự.',
            'year.regex' => 'Năm học phải có định dạng YYYY-YYYY (ví dụ: 2024-2025).',
            'semester.required' => 'Học kỳ không được để trống.',
            'semester.in' => 'Học kỳ phải là một trong các giá trị: Học Kỳ 1, Học Kỳ 2, Học Kỳ 3.',
            'evaluation_start.required' => 'Ngày bắt đầu đánh giá không được để trống.',
            'evaluation_start.date' => 'Ngày bắt đầu đánh giá phải là ngày hợp lệ.',
            'evaluation_end.required' => 'Ngày kết thúc đánh giá không được để trống.',
            'evaluation_end.date' => 'Ngày kết thúc đánh giá phải là ngày hợp lệ.',
            'evaluation_end.after' => 'Ngày kết thúc đánh giá phải sau ngày bắt đầu đánh giá.',
        ];
    }
}
