<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationStatusesRequest extends FormRequest
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
            'notification_id' => 'required|integer|exists:notifications,id',
            'is_read' => 'boolean',
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
            'notification_id' => 'Thông báo',
            'is_read' => 'Đã đọc',
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
            'notification_id.required' => 'Thông báo không được để trống.',
            'notification_id.integer' => 'Thông báo phải là số nguyên.',
            'notification_id.exists' => 'Thông báo được chọn không tồn tại.',
            'is_read.boolean' => 'Trạng thái đọc phải là true hoặc false.',
        ];
    }
}
