<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationsRequest extends FormRequest
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
            'title' => 'required|string|min:5|max:255',
            'message' => 'required|string|min:10|max:1000',
            'semester_score_id' => 'required|integer|exists:semester_scores,id',
            'recipient_type' => 'required|in:student,class_officer,teacher',
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
            'title' => 'Tiêu đề',
            'message' => 'Nội dung thông báo',
            'semester_score_id' => 'Kỳ đánh giá',
            'recipient_type' => 'Loại người nhận',
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
            'title.required' => 'Tiêu đề không được để trống.',
            'title.string' => 'Tiêu đề phải là chuỗi ký tự.',
            'title.min' => 'Tiêu đề phải có ít nhất 5 ký tự.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'message.required' => 'Nội dung thông báo không được để trống.',
            'message.string' => 'Nội dung thông báo phải là chuỗi ký tự.',
            'message.min' => 'Nội dung thông báo phải có ít nhất 10 ký tự.',
            'message.max' => 'Nội dung thông báo không được vượt quá 1000 ký tự.',
            'semester_score_id.required' => 'Kỳ đánh giá không được để trống.',
            'semester_score_id.integer' => 'Kỳ đánh giá phải là số nguyên.',
            'semester_score_id.exists' => 'Kỳ đánh giá được chọn không tồn tại.',
            'recipient_type.required' => 'Loại người nhận không được để trống.',
            'recipient_type.in' => 'Loại người nhận phải là một trong các giá trị: sinh viên, cán bộ lớp, giảng viên.',
        ];
    }
}
