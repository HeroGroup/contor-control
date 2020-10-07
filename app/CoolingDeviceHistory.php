<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoolingDeviceHistory extends Model
{
    protected $fillable = ['cooling_device_id', 'mode_id', 'degree'];

    public function coolingDevice()
    {
        return $this->belongsTo(CoolingDevice::class);
    }

    public function mode()
    {
        return $this->belongsTo(CoolingDeviceModes::class);
    }
}
