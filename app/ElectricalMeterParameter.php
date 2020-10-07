<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElectricalMeterParameter extends Model
{
    protected $fillable = [
        'electrical_meter_type_id',
        'parameter_code',
        'parameter_title',
        'parameter_unit',
        'parameter_type', // serial,tariff,voltage,current,date,time,unimportant
        'parameter_type_index',
        'priority',
        'parameter_label',
    ];

    public function electricalMeterType()
    {
        return $this->belongsTo(ElectricalMeterType::class);
    }
}
