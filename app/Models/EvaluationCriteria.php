<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EvaluationCriteria extends Model
{
    protected $table = 'evaluation_criteria';

    protected $fillable = [
        'name',
        'parent_id',
    ];

    protected $casts = [
        'parent_id' => 'integer',
    ];

    /**
     * Get the parent criteria.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(EvaluationCriteria::class, 'parent_id');
    }

    /**
     * Get the child criteria.
     */
    public function children(): HasMany
    {
        return $this->hasMany(EvaluationCriteria::class, 'parent_id');
    }

    /**
     * Get the evaluation details for this criteria.
     */
    public function evaluationDetails(): HasMany
    {
        return $this->hasMany(EvaluationDetails::class, 'evaluation_criteria_id');
    }
}
