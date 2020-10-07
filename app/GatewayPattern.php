<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GatewayPattern extends Model
{
    protected $fillable = [
        'gateway_id',
        'max_current', 'minutes_after', 'relay_status', 'off_minutes',
        // 'pattern_id'
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
