<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoolingDeviceType extends Model
{
    protected $fillable = [ 'manufacturer' , 'model' ];
}
