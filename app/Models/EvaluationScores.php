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
        'user_id',
        'semester_score_id',
        'score',
        'evaluation_type',
        'notes',
        'submitted_at',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'user_id' => 'integer',
        'semester_score_id' => 'integer',
        'approved_by' => 'integer',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function semesterScore(): BelongsTo
    {
        return $this->belongsTo(SemesterScores::class, 'semester_score_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
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
        return $query->where('evaluation_type', $type);
    }
}
