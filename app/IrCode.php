<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IrCode extends Model
{
    protected $fillable = [ 'cooling_device_type_id' , 'degree' , 'mode' , 'status' , 'code' ];

    public function coolingDeviceType()
    {
        return $this->belongsTo(CoolingDeviceType::class);
    }
}
