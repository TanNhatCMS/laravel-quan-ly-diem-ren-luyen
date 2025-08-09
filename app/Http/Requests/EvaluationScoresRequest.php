<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvaluationScoresRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Check both backpack auth (for web routes) and API auth (for JWT routes)
        return backpack_auth()->check() || auth('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'student_id' => 'required|integer|exists:users,id',
            'teacher_id' => 'nullable|integer|exists:users,id',
            'evaluation_detail_id' => 'required|integer|exists:evaluation_details,id',
            'semester_score_id' => 'required|integer|exists:semester_scores,id',
            'score' => 'required|numeric|min:0|max:100',
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
            //
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
            'student_id.required' => 'Student is required.',
            'student_id.exists' => 'Selected student does not exist.',
            'teacher_id.exists' => 'Selected teacher does not exist.',
            'evaluation_detail_id.required' => 'Evaluation detail is required.',
            'evaluation_detail_id.exists' => 'Selected evaluation detail does not exist.',
            'semester_score_id.required' => 'Semester score period is required.',
            'semester_score_id.exists' => 'Selected semester score period does not exist.',
            'score.required' => 'Score is required.',
            'score.numeric' => 'Score must be a number.',
            'score.min' => 'Score must be at least 0.',
            'score.max' => 'Score must not exceed 100.',
        ];
    }
}
