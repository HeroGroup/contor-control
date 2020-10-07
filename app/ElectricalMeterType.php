<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElectricalMeterType extends Model
{
    protected $fillable = [
        'manufacturer',
        'model'
    ];
}
