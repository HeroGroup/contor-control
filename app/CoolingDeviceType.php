<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoolingDeviceType extends Model
{
    protected $fillable = [
        'manufacturer',
        'model',
        'number_of_phases',
        'warm_current',
        'cool_current',
        'fan_current'
    ];
}
