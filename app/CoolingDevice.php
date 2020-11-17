<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoolingDevice extends Model
{
    use SoftDeletes;
    protected $fillable = ['gateway_id', 'serial_number', 'name', 'mode', 'degree'];

    public function gateway()
    {
        return $this->belongsTo(Gateway::class);
    }

    public function modeName()
    {
        return $this->belongsTo(CoolingDeviceModes::class, 'mode', 'id');
    }
}
