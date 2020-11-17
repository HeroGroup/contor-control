<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupRow extends Model
{
    protected $fillable = [
        'group_id', 'gateway_id', 'cooling_device_id'
    ];
}
