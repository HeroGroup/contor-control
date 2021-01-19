<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gateway extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'gateway_id',
        'serial_number',
        'send_data_duration_seconds',
        'gateway_type',
        'city_id'
    ];

    public function electricalMeters()
    {
        return $this->hasMany(ElectricalMeter::class);
    }

    public function getElectricalMeterIds()
    {
        $re = [$this->serial_number];
        $electricalMeters = ElectricalMeter::where('gateway_id', $this->id)->get(['unique_id']);
        foreach ($electricalMeters as $electricalMeter)
                array_push($re, $electricalMeter->unique_id);
        $result = [implode(",", $re)];

        $gateways = Gateway::where('gateway_id', $this->id)->get(['id','serial_number']);
        foreach ($gateways as $gateway) {
            $re = [$gateway->serial_number];
            $electricalMeters = ElectricalMeter::where('gateway_id', $gateway->id)->get(['unique_id']);
            foreach ($electricalMeters as $electricalMeter)
                array_push($re, $electricalMeter->unique_id);

            array_push($result, implode(",", $re));
        }

        return $result;
    }

    public function getCoolingDeviceIds()
    {
        $result = [];
        $coolingDevices = CoolingDevice::where('gateway_id', $this->id)->get(['serial_number']);
        $re = [$this->serial_number];
        if ($coolingDevices->count() > 0) {
            foreach ($coolingDevices as $coolingDevice)
                array_push($re, $coolingDevice->serial_number);
        }
        $result = [implode("&", $re)];
        $gateways = Gateway::where('gateway_id', $this->id)->get(['id','serial_number']);
        foreach ($gateways as $gateway) {
            $re = [$gateway->serial_number];
            $coolingDevices = CoolingDevice::where('gateway_id', $gateway->id)->get(['serial_number']);
            if ($coolingDevices->count() > 0) {
                foreach ($coolingDevices as $coolingDevice)
                    array_push($re, $coolingDevice->serial_number);
            }
            array_push($result, implode("&", $re));
        }

        return $result;
    }

    public function parentGateway()
    {
        return $this->belongsTo(Gateway::class, 'gateway_id', 'id');
    }

    public function patterns()
    {
        return $this->hasMany(GatewayPattern::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
