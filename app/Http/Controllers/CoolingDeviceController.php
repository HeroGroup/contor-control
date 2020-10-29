<?php

namespace App\Http\Controllers;

use App\CoolingDevice;
use App\CoolingDeviceHistory;
use App\CoolingDeviceModes;
use App\CoolingDevicePattern;
use App\Gateway;
use App\Pattern;
use Illuminate\Http\Request;

class CoolingDeviceController extends Controller
{
    public function index($gateway=0)
    {
        // dd($gateway);
        $coolingDevices = $gateway > 0 ? CoolingDevice::where('gateway_id', $gateway)->get() : CoolingDevice::all();
        return view('coolingDevices.index', compact('gateway', 'coolingDevices'));
    }

    public function create($gateway=0)
    {
        $gateways = Gateway::pluck('serial_number', 'id')->toArray();
        return view('coolingDevices.create', compact('gateway', 'gateways'));
    }

    public function store(Request $request)
    {
        CoolingDevice::create($request->all());
        return redirect(route('coolingDevices.index', 0));
    }

    public function edit(CoolingDevice $coolingDevice)
    {
        $gateways = Gateway::pluck('serial_number', 'id')->toArray();
        return view('coolingDevices.edit', compact('coolingDevice', 'gateways'));
    }

    public function update(Request $request, CoolingDevice $coolingDevice)
    {
        $coolingDevice->update($request->all());
        return redirect(route('coolingDevices.index', 0));
    }

    public function destroy(CoolingDevice $coolingDevice)
    {
        // try {
        //     $coolingDevice->delete();
        //     return redirect(route('coolingDevices.index'));
        // } catch (\Exception $exception) {
        //     throw;
        // }
        return redirect('/admin/coolingDevices/0')->with('message', 'در حال حاضر امکان حذف وجود ندارد.')->with('type', 'danger');
    }

    public function history($id)
    {
        $device = CoolingDevice::find($id);
        $histories = CoolingDeviceHistory::where('cooling_device_id', $id)->get();
        return view('coolingDevices.history', compact('device', 'histories'));
    }

    public function patterns(CoolingDevice $device)
    {
        // $patterns = CoolingDevicePattern::where('cooling_device_id', $device->id)->get();
        $patterns = Pattern::where('cooling_device_id', $device->id)->get();
        $gateway = $device->gateway->id;
        return view('coolingDevices.patterns', compact('device', 'patterns', 'gateway'));
    }

    public function changeStatus($deviceId)
    {
        $device = CoolingDevice::find($deviceId);
        $modes = CoolingDeviceModes::pluck('name', 'id')->toArray();
        return view('coolingDevices.changeStatus', compact('device', 'modes'));
    }
}
