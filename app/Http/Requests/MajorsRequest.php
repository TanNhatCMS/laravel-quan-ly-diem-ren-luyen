<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MajorsRequest extends FormRequest
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
        $majorId = $this->route('id') ?? $this->route('major');

        return [
            'code' => 'required|string|max:255|unique:majors,code,'.$majorId,
            'name' => 'required|string|min:2|max:255',
            'organization_id' => 'required|integer|exists:organizations,id',
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
            'code' => 'Mã ngành',
            'name' => 'Tên ngành',
            'organization_id' => 'Tổ chức',
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
            'code.required' => 'Mã ngành không được để trống.',
            'code.string' => 'Mã ngành phải là chuỗi ký tự.',
            'code.max' => 'Mã ngành không được vượt quá 255 ký tự.',
            'code.unique' => 'Mã ngành này đã tồn tại.',
            'name.required' => 'Tên ngành không được để trống.',
            'name.string' => 'Tên ngành phải là chuỗi ký tự.',
            'name.min' => 'Tên ngành phải có ít nhất 2 ký tự.',
            'name.max' => 'Tên ngành không được vượt quá 255 ký tự.',
            'organization_id.required' => 'Tổ chức không được để trống.',
            'organization_id.integer' => 'Tổ chức phải là số nguyên.',
            'organization_id.exists' => 'Tổ chức được chọn không tồn tại.',
        ];
    }
}
