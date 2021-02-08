<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Gateway;
use App\CoolingDevice;
use App\ElectricalMeter;
use App\ElectricalMeterHistory;
use App\CoolingDeviceHistory;

class V2Controller extends Controller
{
    public function postElectricityMeterData(Request $request)
    {
        // $request->gateway_id string
        // $request->contor_data string
        // $request->nodes array of strings separated with exclamation (!)

        try {
            $log = logIncomingData($request->getContent(), $request->header('User-Agent'));
            if (!$log)
                return $this->fail("invalid or empty data");


            foreach ($request->data as $datum) {
                $elm = explode("!", $datum);
                $data = explode("&", $elm[0]);
                $gateway = Gateway::where('serial_number', 'like', $data[0])->first();
                $electricalMeter = ElectricalMeter::where('gateway_id', $gateway->id)->first();
                if ($electricalMeter) {
                    ElectricalMeterHistory::create([
                        'electrical_meter_id' => $electricalMeter->id,
                        'parameter_values' => $elm[0],
                        'current' => $data[10]
                    ]);
                } else {
                    logException($request->gateway_id, "invalid electrical meter id $data[0] with serial $data[1]");
                }

                for($j=1; $j<count($elm); $j++) {
                    $data = explode("&", $elm[$j]);
                    $coolingDevice = CoolingDevice::where('serial_number', 'like', $data[0])->first();
                    if ($coolingDevice) {
                        $roomTemperature = isset($data[3]) ? $data[3] : "-99";
                        CoolingDeviceHistory::create([
                            'cooling_device_id' => $coolingDevice->id,
                            'mode_id' => $data[1],
                            'degree' => $data[2],
                            'room_temperature' => $roomTemperature
                        ]);
                        $coolingDevice->update(['room_temperature' => $roomTemperature]);
                    } else {
                        logException($request->gateway_id, "invalid cooling device ".$data[0]);
                    }
                }
            }

            return $this->success('data posted successfully');
        } catch (\Exception $exception) {
            logException("General", $exception->getLine().': '.$exception->getMessage());
            return $this->fail($exception->getLine().': '.$exception->getMessage());
        }
    }
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

    public function getTime()
    {
        return $this->success("", ["server_time" => date('H:i')]);
    }
}
