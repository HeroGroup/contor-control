<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pattern extends Model
{
    protected $fillable = [
        'cooling_device_id','start_time', 'end_time', 'mode_id', 'degree',
        // 'max_current', 'minutes_after', 'relay_status', 'off_minutes',
        // 'type', // cooling, gateway
    ];

    public function mode()
    {
        return $this->belongsTo(CoolingDeviceModes::class);
    }
}
