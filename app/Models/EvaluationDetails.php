<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}