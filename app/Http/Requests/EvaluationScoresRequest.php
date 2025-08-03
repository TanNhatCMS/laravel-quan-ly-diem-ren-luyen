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
            'user_id' => 'required|integer|exists:users,id',
            'semester_score_id' => 'required|integer|exists:semester_scores,id',
            'score' => 'required|numeric|min:0|max:100',
            'evaluation_type' => 'required|string|in:self,class,organization',
            'notes' => 'nullable|string|max:1000',
            'submitted_at' => 'nullable|date',
            'approved_at' => 'nullable|date|after_or_equal:submitted_at',
            'approved_by' => 'nullable|integer|exists:users,id',
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
            'user_id.required' => 'User is required.',
            'user_id.exists' => 'Selected user does not exist.',
            'semester_score_id.required' => 'Semester score period is required.',
            'semester_score_id.exists' => 'Selected semester score period does not exist.',
            'score.required' => 'Score is required.',
            'score.numeric' => 'Score must be a number.',
            'score.min' => 'Score must be at least 0.',
            'score.max' => 'Score must not exceed 100.',
            'evaluation_type.required' => 'Evaluation type is required.',
            'evaluation_type.in' => 'Evaluation type must be one of: self, class, organization.',
            'notes.max' => 'Notes must not exceed 1000 characters.',
            'approved_at.after_or_equal' => 'Approval date must be after or equal to submission date.',
            'approved_by.exists' => 'Selected approver does not exist.',
        ];
    }
}
