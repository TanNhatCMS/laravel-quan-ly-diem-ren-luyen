<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lop extends Model
{
    protected $table = 'lops';

    public function khoa()
    {
        return $this->belongsTo('App\Models\Khoa');
    }
}
