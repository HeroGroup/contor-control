<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GatewayPattern extends Model
{
    protected $fillable = [
        'gateway_id', 'pattern_id'
    ];

    public function gateway()
    {
        return $this->belongsTo(Gateway::class);
    }

    public function pattern()
    {
        return $this->belongsTo(Pattern::class);
    }
}
