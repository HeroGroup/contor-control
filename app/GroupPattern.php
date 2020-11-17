<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupPattern extends Model
{
    protected $fillable = [
        'group_id', 'pattern_id'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function pattern()
    {
        return $this->belongsTo(Pattern::class);
    }
}
