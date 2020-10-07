<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElectricalMeter extends Model
{
    protected $fillable = [
        'gateway_id',
        'unique_id',
        'serial_number',
        'electrical_meter_type_id',
        'phase',
        'relay1_status',
        'relay2_status',
    ];

    public function gateway()
    {
        return $this->belongsTo(Gateway::class);
    }

    public function type()
    {
        return $this->belongsTo(ElectricalMeterType::class, 'electrical_meter_type_id', 'id');
    }
}

