<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProfilesRequest extends FormRequest
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
        $userId = $this->route('id') ?? $this->route('user_profile');

        return [
            'user_id' => 'required|integer|exists:users,id',
            'code' => 'nullable|string|max:255|unique:user_profiles,code,'.$userId,
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'required|in:male,female,other',
            'type' => 'nullable|in:student,teacher',
            'education_system' => 'nullable|in:TH,CD,CL',
            'phone_number' => 'nullable|string|regex:/^[0-9]{10,11}$/',
            'academic_degree_id' => 'nullable|integer|exists:academic_degrees,id',
            'class_id' => 'nullable|integer|exists:classes,id',
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
            'code' => 'Mã số',
            'birth_date' => 'Ngày sinh',
            'gender' => 'Giới tính',
            'type' => 'Loại người dùng',
            'education_system' => 'Hệ đào tạo',
            'phone_number' => 'Số điện thoại',
            'academic_degree_id' => 'Trình độ học vấn',
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
            'code.string' => 'Mã số phải là chuỗi ký tự.',
            'code.max' => 'Mã số không được vượt quá 255 ký tự.',
            'code.unique' => 'Mã số này đã tồn tại.',
            'birth_date.date' => 'Ngày sinh phải là ngày hợp lệ.',
            'birth_date.before' => 'Ngày sinh phải trước ngày hôm nay.',
            'gender.required' => 'Giới tính không được để trống.',
            'gender.in' => 'Giới tính phải là một trong các giá trị: nam, nữ, khác.',
            'type.in' => 'Loại người dùng phải là sinh viên hoặc giảng viên.',
            'education_system.in' => 'Hệ đào tạo phải là một trong các giá trị: TH, CD, CL.',
            'phone_number.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'phone_number.regex' => 'Số điện thoại phải có 10-11 chữ số.',
            'academic_degree_id.integer' => 'Trình độ học vấn phải là số nguyên.',
            'academic_degree_id.exists' => 'Trình độ học vấn được chọn không tồn tại.',
            'class_id.integer' => 'Lớp học phải là số nguyên.',
            'class_id.exists' => 'Lớp học được chọn không tồn tại.',
        ];
    }
}
