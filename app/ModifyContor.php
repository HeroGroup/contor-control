<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModifyContor extends Model
{
    protected $fillable = [
        'gateway_id',
        'electrical_meter_id',
        'cooling_device_id',
        'relay1_status',
        'relay2_status',
        'checked'
    ];

    public function gateway()
    {
        return $this->belongsTo(Gateway::class);
    }

    public function electricalMeter()
    {
        return $this->belongsTo(ElectricalMeter::class);
    }

    public function coolingDevice()
    {
        return $this->belongsTo(CoolingDevice::class);
    }
}
