<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElectricalMeterHistory extends Model
{
    protected $fillable = [
        'electrical_meter_id',
        // 'electrical_meter_parameter_id',
        // 'parameter_value',
        'parameter_values',
        'current',
        'fixed_time'
    ];

    protected $table = "electrical_meter_histories";

    public function electricalMeter()
    {
        return $this->belongsTo(ElectricalMeter::class);
    }
/*
    public function electricalMeterParameter()
    {
        return $this->belongsTo(ElectricalMeterParameter::class);
    }
*/
}

