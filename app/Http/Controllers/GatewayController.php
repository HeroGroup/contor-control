<?php

namespace App\Http\Controllers;

use App\CoolingDevice;
use App\CoolingDeviceHistory;
use App\ElectricalMeter;
use App\ElectricalMeterHistory;
use App\ElectricalMeterParameter;
use App\ElectricalMeterType;
use App\Events\MeterDataUpdated;
use App\Gateway;
use App\ModifyContor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GatewayController extends Controller
{
    protected $electricalMeterParametersMap = [ /*array_index=>parameters_table_id*/
        1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10, 11=>11, 12=>12
    ];

    public function fill()
    {
        // gateways
        Gateway::create([
            'serial_number' => '60000001',
            'send_data_duration_seconds' => 60
        ]);

        // electrical meter type
        ElectricalMeterType::create([
            'manufacturer' => 'x',
            'model' => 'model x'
        ]);

        // electrical meters
        ElectricalMeter::create([
            'unique_id' => '61000001',
            'serial_number' => '12939958',
            'gateway_id' => 1,
            'electrical_meter_type_id' => 1,
            'phase' => '1',
            'relay1_status' => '1',
            'relay2_status' => '1',
        ]);
        ElectricalMeter::create([
            'unique_id' => '61000002',
            'serial_number' => '61000002',
            'gateway_id' => 1,
            'electrical_meter_type_id' => 1,
            'phase' => '1',
            'relay1_status' => '1',
            'relay2_status' => '1',
        ]);

        // electrical meter parameters
        $items = [
            ['title' => 'serial_number', 'unit' => null, 'type' => 'serial', 'index' => null],
            ['title' => 'date', 'unit' => null, 'type' => 'date', 'index' => null],
            ['title' => 'time', 'unit' => null, 'type' => 'time', 'index' => null],
            ['title' => 'active_import_energy_tariff_1', 'unit' => 'kWh', 'type' => 'tariff', 'index' => '1'],
            ['title' => 'active_import_energy_tariff_2', 'unit' => 'kWh', 'type' => 'tariff', 'index' => '2'],
            ['title' => 'active_import_energy_tariff_3', 'unit' => 'kWh', 'type' => 'tariff', 'index' => '3'],
            ['title' => 'active_import_energy_tariff_4', 'unit' => 'kWh', 'type' => 'tariff', 'index' => '4'],
            ['title' => 'total_active_import_energy', 'unit' => 'unimportant', 'type' => null, 'index' => null],
            ['title' => 'voltage', 'unit' => 'V', 'type' => 'voltage', 'index' => null],
            ['title' => 'current', 'unit' => 'A', 'type' => 'current', 'index' => null],
            ['title' => 'relay1_status', 'unit' => null, 'type' => 'unimportant', 'index' => null],
            ['title' => 'relay2_status', 'unit' => null, 'type' => 'unimportant', 'index' => null],
        ];
        foreach ($items as $item) {
            ElectricalMeterParameter::create([
                'electrical_meter_type_id' => 1,
                'parameter_title' => $item['title'],
                'parameter_unit' => $item['unit'],
                'parameter_type' => $item['type'],
                'parameter_type_index' => $item['index'],
            ]);
        }

        return $this->success('data inserted successfully');
    }

    public function postElectricityMeterData(Request $request)
    {
        try {
            logIncomingData($request->getContent());

            // $result = [];
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

                    // for ($i = 1; $i < count($data); $i++) {
                        // ElectricalMeterHistory::create([
                            // 'electrical_meter_id' => $electricalMeter->id,
                            // 'electrical_meter_parameter_id' => $this->electricalMeterParametersMap[$i],
                            // 'parameter_value' => $data[$i]
                        // ]);

                        /*
                        if ($i == 11) { // relay1_status
                            // if there has been a modification, check result and modify checked
                            $maxId = ModifyContor::where('electrical_meter_id', $electricalMeter->id)->where('checked', 0)->max('id');
                            $lastModify = ModifyContor::find($maxId);
                            if ($lastModify) {
                                if ($lastModify->relay1_status == $data[$i]) {
                                    // change was successfully implemented
                                    ModifyContor::where('electrical_meter_id', $electricalMeter->id)
                                        ->where('checked', 0)
                                        ->update(['checked' => 1]);

                                    ElectricalMeter::find($electricalMeter->id)->update(['relay1_status' => $data[$i]]);
                                } else {
                                    // was not able to change relay1 status // pass
                                }
                            }
                        }
                        */
                    // }


                    // $newData = $this->getLatestElectricalMeterConfig($electricalMeter->id);
                    // event(new MeterDataUpdated($newData['data']));
                } else {
                    logException($request->gateway_id, "invalid electrical meter id $data[0] with serial $data[1]");
                }

                for($j=1; $j<count($elm); $j++) {
                    $data = explode("&", $elm[$j]);
                    $coolingDevice = CoolingDevice::where('serial_number', 'like', $data[0])->first();
                    if ($coolingDevice) {
                        CoolingDeviceHistory::create([
                            'cooling_device_id' => $coolingDevice->id,
                            'mode_id' => $data[1],
                            'degree' => $data[2],
                            'room_temperature' => $data[3]
                        ]);
                        $coolingDevice->update(['room_temperature' => $data[3]]);
                        /*
                        ModifyContor::where('cooling_device_id', $coolingDevice->id)
                            ->where('gateway_id', $gateway->id)
                            ->where('checked', 0)
                            ->where('relay1_status', $elm[$j][1])
                            ->where('relay2_status', $elm[$j][2])
                            ->update(['checked' => 1]);
                        */
                    } else {
                        logException($request->gateway_id, "invalid cooling device ".$data[0]);
                    }
                }

                // array_push($result, $data);
            }

            return $this->success('data posted successfully');
        } catch (\Exception $exception) {
            logException("General", $exception->getLine().': '.$exception->getMessage());
            return $this->fail($exception->getLine().': '.$exception->getMessage());
        }
    }

    public function getAMIGatewayConfig($gatewayId)
    {
        try {
            $gateway = Gateway::where('serial_number', 'LIKE', $gatewayId)->first();
            if ($gateway) {
                $data = [
                    "send_data_duration" => $gateway->send_data_duration_seconds,
                    "meter_serial_number" => $gateway->electricalMeters->first()->serial_number,
                    "meter_model" => $gateway->electricalMeters->first()->type->manufacturer.$gateway->electricalMeters->first()->type->model,
                    "controller_list" => $gateway->getCoolingDeviceIds()
                ];

                generalLog('getAMIGatewayConfig', $gatewayId, $data);
                return $this->success('data retrieved successfully', $data);
            } else {
                logException($gatewayId, 'getAMIGatewayConfig invalid gateway id');
                return $this->fail('invalid gateway id');
            }
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            logException($gatewayId, "getAMIGatewayConfig $message");
            return $this->fail($message);
        }
    }

    public function getLatestElectricalMeterConfig($gatewayId)
    {
        $values = [
            1 => 'serial_number', // 66777788889999
            2 => 'date', // 1399100716375
            3 => 'time', // 1399100716375
            4 => 'active_import_energy_tariff_1', // 00000.15
            5 => 'active_import_energy_tariff_2', // 00000.00
            6 => 'active_import_energy_tariff_3', // 00000.00
            7 => 'active_import_energy_tariff_4', // 00000.00
            8 => 'total_active_import_energy', // 00.000
            9 => 'voltage', // 225.95
            10 => 'current', // 000.00
            11 => 'relay1_status', // 0
            12 => 'relay2_status', // 0
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

    public function updateElectricityMeterRelayStatus(Request $request)
    {
        return $this->updateRelayStatus($request->gateway_id, $request->relay1_status, null);
    }

    public function updateElectricityMeterRelay2Status(Request $request)
    {
        return $this->updateRelayStatus($request->gateway_id, null, $request->relay2_status);
    }

    public function updateRelayStatus($serialNumber, $relay1, $relay2)
    {
        $r1 = $relay1;
        $r2 = $relay2;
        $gateway = Gateway::where('serial_number','like',$serialNumber)->first();
        $electricalMeter = ElectricalMeter::where('gateway_id', $gateway->id)->first();
        if ($electricalMeter) {
            if ($r1 == null) {
                $maxId = ModifyContor::where('gateway_id', $gateway->id)
                    ->whereNotNull('electrical_meter_id')
                    ->where('checked', 0)
                    ->max('id');

                $latestModify = ModifyContor::find($maxId);

                $r1 = $latestModify ? $latestModify->relay1_status : $electricalMeter->relay1_status;
            }

            if ($r2 == null) {
                $maxId = ModifyContor::where('gateway_id', $gateway->id)
                    ->whereNotNull('electrical_meter_id')
                    ->where('checked', 0)
                    ->max('id');
                $latestModify = ModifyContor::find($maxId);
                $r2 = $latestModify ? $latestModify->relay2_status : $electricalMeter->relay2_status;
            }

            ModifyContor::create([
                'gateway_id' => $gateway->id,
                'electrical_meter_id' => $electricalMeter->id,
                'relay1_status' => $r1,
                'relay2_status' => $r2
            ]);

            return $this->success('درخواست تغییر وضعیت کنتور با موفقیت ارسال شد.');
        } else {
            return $this->fail('invalid associated gateway id');
        }
    }

    public function updateCoolingDevice(Request $request)
    {
        $coolingDevice = CoolingDevice::where('serial_number', $request->cooling_device)->first();
        if ($coolingDevice) {
            $gatewayId = $coolingDevice->gateway_id;

            if ($request->mode == 3 || $request->mode == 4)
                if (! $request->temperature > 0)
                    return $this->fail("درجه تنظیم نشده است.");

            ModifyContor::create([
                'gateway_id' => $gatewayId,
                'cooling_device_id' => $coolingDevice->id,
                'relay1_status' => $request->mode ? $request->mode : 0,
                'relay2_status' => $request->temperature ? $request->temperature : 0
            ]);

            return $this->success('درخواست تغییر وضعیت اسپیلیت با موفقیت ارسال شد.');
        } else {
            return $this->fail('invalid associated gateway id');
        }
    }

    public function getElectricityMeterFieldModify($gatewayId)
    {
        try {
            $parentGateway = Gateway::where('serial_number', 'LIKE', $gatewayId)->first();
            if ($parentGateway) {
                $gateways = Gateway::where('id', $parentGateway->id)->orWhere('gateway_id', $parentGateway->id)->get();
                $result = [];
                foreach ($gateways as $gateway) {
                    $maxId = ModifyContor::where('gateway_id', $gateway->id)
                        ->whereNotNull('electrical_meter_id')
                        ->where('checked', 0)
                        ->max('id');
                    $gateWayModified = ModifyContor::find($maxId);

                    if ($gateWayModified) {
                        $resultItem = $gateway->serial_number . "&" . $gateWayModified->relay1_status . "&" . $gateWayModified->relay2_status;
                    } else {
                        $electricalMeter = ElectricalMeter::where('gateway_id', $gateway->id)->first();
                        $resultItem = $gateway->serial_number . "&" . $electricalMeter->relay1_status . "&" . $electricalMeter->relay2_status;
                    }

                    $coolingModified = ModifyContor::where('gateway_id', $gateway->id)
                        ->whereNotNull('cooling_device_id')
                        ->where('checked', 0)
                        ->distinct()
                        ->get(['cooling_device_id']);

                    foreach ($coolingModified as $item) {
                        $maxId = ModifyContor::where('cooling_device_id', $item->cooling_device_id)->where('checked', 0)->max('id');
                        $contor = ModifyContor::find($maxId);
                        $resultItem .= "!" . $contor->coolingDevice->serial_number . "&" . $contor->relay1_status . "&" . $contor->relay2_status . "&" . $contor->coolingDevice->remote_manufacturer . "&" . $contor->coolingDevice->rf_broadcast_enable;
                    }

                    if ($gateWayModified || $coolingModified->count() > 0)
                        array_push($result, $resultItem);
                }

                // $data = ["meter_controller_config" => $result];
                $data = $result;
                generalLog('getElectricityMeterFieldModify', $gatewayId, json_encode($data));
                return $this->success('data retrieved successfully', $data);
            } else {
                logException($gatewayId, 'getElectricityMeterFieldModify invalid gateway id');
                return $this->fail('invalid gateway');
            }
        } catch (\Exception $exception) {
            $message = $exception->getLine().': '.$exception->getMessage();
            logException($gatewayId, $message);
            return $this->fail($message);
        }
    }

    public function confirmFieldModify(Request $request)
    {
        $gatewayId=0;
        try {
            logConfirmData($request->getContent());
            foreach ($request->data as $item) {
                $gatewayData = explode("!", $item);
                $contorData = explode("&", $gatewayData[0]);
                $gatewayId = $contorData[0];
                $gateway = Gateway::where('serial_number', 'like', $contorData[0])->first();
                if ($gateway) {
                    $gatewayModified = ModifyContor::where('gateway_id', $gateway->id)
                        ->whereNotNull('electrical_meter_id')
                        ->where('relay1_status', $contorData[1])
                        ->where('relay2_status', $contorData[2])
                        ->where('checked', 0)
                        ->orderBy('id', 'desc')
                        ->first();

                    if ($gatewayModified) {
                        ModifyContor::where('gateway_id', $gateway->id)
                            ->whereNotNull('electrical_meter_id')
                            ->where('id','<=',$gatewayModified->id)
                            ->where('checked', 0)
                            ->update(['checked' => 1]);
                    }

                    $electricalMeter = ElectricalMeter::where('gateway_id', $gateway->id)->first();
                    if ($electricalMeter)
                        $electricalMeter->update([
                            'relay1_status' => $contorData[1],
                            'relay2_status' => $contorData[2]
                        ]);
                }
                for($i=1; $i<count($gatewayData); $i++) { // cooling devices
                    $coolingData = explode("&", $gatewayData[$i]);
                    $coolingDevice = CoolingDevice::where('serial_number', 'like', $coolingData[0])->first();
                    if ($coolingDevice) {
                        $deviceModified = ModifyContor::where('gateway_id', $gateway->id)
                            ->where('cooling_device_id', $coolingDevice->id)
                            ->where('relay1_status', $coolingData[1])
                            ->where('relay2_status', $coolingData[2])
                            ->where('checked', 0)
                            ->orderBy('id','desc')
                            ->first();

                        if ($deviceModified) {
                            ModifyContor::where('gateway_id', $gateway->id)
                                ->where('cooling_device_id', $coolingDevice->id)
                                ->where('id', '<=',$deviceModified->id)
                                ->where('checked', 0)
                                ->update(['checked' => 1]);
                        }

                        $coolingDevice->update(['mode' => $coolingData[1], 'degree' => $coolingData[2], 'room_temperature' => $coolingData[5]]);

                        CoolingDeviceHistory::create([
                            'cooling_device_id' => $coolingDevice->id,
                            'mode_id' => $coolingData[1],
                            'degree' => $coolingData[2],
                            'room_temperature' => $coolingData[5]
                        ]);
                    }
                }
            }

            return $this->success("Data Confirmed Successfully");
        } catch (\Exception $exception) {
            $message = $exception->getLine() . ': ' . $exception->getMessage();
            logException($gatewayId, $message);
            return $this->fail($message);
        }
    }

}
