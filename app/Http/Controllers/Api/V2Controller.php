<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Gateway;
use App\ElectricalMeter;
use App\ElectricalMeterHistory;

class V2Controller extends Controller
{
    public function getLatestElectricalMeterConfig($gatewayId)
    {
        $values = [
            1 => 'serial_number',
            2 => 'date',
            3 => 'time',
            4 => 'active_import_energy_tariff_1',
            5 => 'active_import_energy_tariff_2',
            6 => 'active_import_energy_tariff_3',
            7 => 'active_import_energy_tariff_4',
            8 => 'total_active_import_energy',
            9 => 'voltage',
            10 => 'current',
            11 => 'relay1_status',
            12 => 'relay2_status',
        ];

        try {
            $gateway = Gateway::where('serial_number','like',$gatewayId)->first();
            $electricalMeterId = ElectricalMeter::where('gateway_id',$gateway->id)->first()->id;
            $result = [];
            $maxId = ElectricalMeterHistory::where('electrical_meter_id', $electricalMeterId)->max('id');
            if ($maxId) {
                $latest = ElectricalMeterHistory::find($maxId);
                $parameters = explode('&', $latest->parameter_values);

                for ($i=1; $i<=10; $i++) {
                    $result[$values[$i]] = $parameters[$i];
                }
            }

            // get ralays staus from main table
            $device = ElectricalMeter::find($electricalMeterId);
            $result["relay1_status"] = strval($device->relay1_status);
            $result["relay2_status"] = strval($device->relay2_status);

            return $this->success('data retrieved successfully', $result);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }
}
