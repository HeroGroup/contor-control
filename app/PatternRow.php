<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatternRow extends Model
{
    protected $fillable = [
        'pattern_id', 'start_time', 'end_time', 'mode_id', 'degree',
        'max_current', 'minutes_after', 'relay_status', 'off_minutes'
    ];

    public function pattern()
    {
        return $this->belongsTo(Pattern::class, 'pattern_id', 'id');
    }

    public function mode()
    {
        return $this->belongsTo(CoolingDeviceModes::class, 'mode_id', 'id');
    }

}
