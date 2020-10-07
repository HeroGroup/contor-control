<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoolingDevice extends Model
{
    protected $fillable = ['gateway_id', 'serial_number', 'mode', 'degree'];

    public function gateway()
    {
        return $this->belongsTo(Gateway::class);
    }

    public function modeName()
    {
        return $this->belongsTo(CoolingDeviceModes::class, 'mode', 'id');
    }
}
