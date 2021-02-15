<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElectricalMeter extends Model
{
    protected $fillable = [
        'gateway_id',
        'unique_id',
        'serial_number',
        'electrical_meter_type_id',
        'customer_name',
        'shenase_moshtarak',
        'parvande',
        'phase',
        'relay1_status',
        'relay2_status',
    ];

    public function gateway()
    {
        return $this->belongsTo(Gateway::class);
    }

    public function type()
    {
        return $this->belongsTo(ElectricalMeterType::class, 'electrical_meter_type_id', 'id');
    }
}

/*

Hello, my love
its getting cold on this island
im sad alone
im so sad on my own
the truth is, we were much too young

now i'm looking for you
or anyone like you
we said goodbye
with the smile on our faces

now you're alone
your'e so sad on your own
the truth is, we ran out of time
now you're looking for me
or anyone like me

hello my love
it's getting cold on this island
im sad alone
im so sad on my own

the truth is, we were much too young
now im looking for you
or anyone like you

*/
