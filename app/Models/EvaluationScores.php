<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluationScores extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'evaluation_scores';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'student_id',
        'teacher_id',
        'evaluation_detail_id',
        'semester_score_id',
        'score',
    ];

    protected $casts = [
        'score' => 'integer',
        'student_id' => 'integer',
        'teacher_id' => 'integer',
        'evaluation_detail_id' => 'integer',
        'semester_score_id' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function evaluationDetail(): BelongsTo
    {
        return $this->belongsTo(EvaluationDetails::class, 'evaluation_detail_id');
    }

    public function semesterScore(): BelongsTo
    {
        return $this->belongsTo(SemesterScores::class, 'semester_score_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the formatted score with percentage.
     */
    public function getFormattedScoreAttribute(): string
    {
        return $this->score.'%';
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    /**
     * Ensure score is within valid range.
     */
    public function setScoreAttribute($value): void
    {
        $this->attributes['score'] = max(0, min(100, (float) $value));
    }

    /**
     * Sanitize evaluation type.
     */
    public function setEvaluationTypeAttribute($value): void
    {
        $allowedTypes = ['self', 'class', 'organization'];
        $this->attributes['evaluation_type'] = in_array($value, $allowedTypes) ? $value : 'self';
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Scope for approved evaluations.
     */
    public function scopeApproved($query)
    {
        return $query->whereNotNull('approved_at');
    }

    /**
     * Scope for pending evaluations.
     */
    public function scopePending($query)
    {
        return $query->whereNull('approved_at');
    }

    /**
     * Scope for specific evaluation type.
     */
    public function scopeByType($query, $type)
    {
        $allowedTypes = ['self', 'class', 'organization'];

        if (! in_array($type, $allowedTypes, true)) {
            throw new InvalidArgumentException("Invalid evaluation type: {$type}");
        }

        return $query->where('evaluation_type', '=', $type);
    }
}
