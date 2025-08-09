<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PositionsRequest extends FormRequest
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
            'name' => 'Tên chức vụ',
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
            'name.required' => 'Tên chức vụ không được để trống.',
            'name.string' => 'Tên chức vụ phải là chuỗi ký tự.',
            'name.min' => 'Tên chức vụ phải có ít nhất 2 ký tự.',
            'name.max' => 'Tên chức vụ không được vượt quá 255 ký tự.',
        ];
    }
}
