<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pattern extends Model
{
    protected $fillable = [
        'name', 'pattern_type', // cooling, gateway
    ];

    public function rows()
    {
        return $this->hasMany(PatternRow::class, 'pattern_id', 'id');
    }
}
