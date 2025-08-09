<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EvaluationDetails extends Model
{
    protected $table = 'evaluation_details';

    protected $fillable = [
        'name',
        'score',
        'evaluation_criteria_id',
    ];

    protected $casts = [
        'score' => 'integer',
        'evaluation_criteria_id' => 'integer',
    ];

    /**
     * Get the evaluation criteria for this detail.
     */
    public function evaluationCriteria(): BelongsTo
    {
        return $this->belongsTo(EvaluationCriteria::class, 'evaluation_criteria_id');
    }

    /**
     * Get the evaluation scores for this detail.
     */
    public function evaluationScores(): HasMany
    {
        return $this->hasMany(EvaluationScores::class, 'evaluation_detail_id');
    }
}
