<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoolingDevicePattern extends Model
{
    protected $fillable = [
        'cooling_device_id', 'pattern_id'
    ];

    public function coolingDevice()
    {
        return $this->belongsTo(CoolingDevice::class);
    }

    public function pattern()
    {
        return $this->belongsTo(Pattern::class);
    }
}
