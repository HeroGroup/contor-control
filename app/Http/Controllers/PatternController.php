<?php

namespace App\Http\Controllers;

use App\CoolingDevice;
use App\CoolingDeviceModes;
use App\Gateway;
use App\Pattern;
use App\GatewayPattern;
use Illuminate\Http\Request;

class PatternController extends Controller
{
    public function getDevices($gateway=null)
    {
        if (!$gateway || $gateway=='') {
            return $this->success('success', []);
        } else {
            $devices = CoolingDevice::where('gateway_id', $gateway)->get(['id', 'serial_number']);
            return $this->success('success', $devices);
        }
    }

    public function createCoolingDevicePattern($gateway=null, $device=null)
    {
        $gateways = Gateway::pluck('serial_number', 'id')->toArray();
        $modes = CoolingDeviceModes::pluck('name', 'id')->toArray();
        return view('patterns.createCoolingDevicePattern',compact('gateways', 'modes', 'gateway', 'device'));
    }

    public function createGatewayPattern()
    {
        $gateways = Gateway::all();
        return view('patterns.createGatewayPattern2', compact('gateways'));
    }

    public function storeGatewayPattern(Request $request)
    {
        try {
            $pattern = GatewayPattern::where('gateway_id', $request->gateway_id)->first();
            if ($pattern) // update
                $pattern->update($request->toArray());
            else // create new
                GatewayPattern::create($request->toArray());

            return $this->success("success");
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    public function store(Request $request)
    {
        if ($request->gateway) {
            if ($request->device) {

                // delete current device patterns
                Pattern::where('cooling_device_id', $request->device)->delete();

                foreach (json_decode($request->data) as $item) {
                    Pattern::create([
                        'cooling_device_id' => $request->device,
                        'start_time' => $item->start,
                        'end_time' => $item->end,
                        'mode_id' => $item->mode,
                        'degree' => $item->degree ? $item->degree : null
                    ]);
                }
            } else {
                // loop through all gateway devices
                $devices = CoolingDevice::where('gateway_id', $request->gateway)->get();
                foreach ($devices as $device) {

                    // delete current device patterns
                    Pattern::where('cooling_device_id', $device->id)->delete();

                    foreach (json_decode($request->data) as $item) {
                        Pattern::create([
                            'cooling_device_id' => $device->id,
                            'start_time' => $item->start,
                            'end_time' => $item->end,
                            'mode_id' => $item->mode,
                            'degree' => $item->degree ? $item->degree : null
                        ]);
                    }
                }
            }
            return $this->success('الگوی مصرف ذخیره شد.');
        } else {
            return $this->fail('درگاه نامعتبر!');
        }
    }
}
