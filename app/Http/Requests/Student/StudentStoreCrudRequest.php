<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreCrudRequest extends FormRequest
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
            'profile.code' => 'required|unique:user_profiles,code',
            'email' => 'required|unique:'.config('backpack.permissionmanager.models.user', 'users').',email',
            'name' => 'required',
            'password' => 'required|confirmed',
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
            'profile.code.unique' => 'Mã sinh viên đã tồn tại',
            'profile.code.required' => 'Mã sinh viên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.unique' => 'Email đã tồn tại',
            'name.required' => 'Tên sinh viên không được để trống',
            'password.required' => 'Mật khẩu không được để trống',
            'password.confirmed' => 'Mật khẩu không khớp',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.max' => 'Mật khẩu không được vượt quá 255 ký tự',
        ];
    }
}
