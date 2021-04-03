<?php

namespace App\Http\Controllers;

use App\CoolingDevice;
use App\CoolingDeviceHistory;
use App\CoolingDeviceModes;
use App\CoolingDevicePattern;
use App\Exports\SplitsExport;
use App\Gateway;
use App\Pattern;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CoolingDeviceController extends Controller
{
    public function index($gateway=0)
    {
        $coolingDevices = $gateway > 0 ? CoolingDevice::where('gateway_id', $gateway)->orderBy('serial_number', 'asc')->get() : CoolingDevice::orderBy('serial_number', 'asc')->get();
        $patterns = Pattern::where('pattern_type', 1)->pluck('name', 'id')->toArray();

        return view('coolingDevices.index', compact('gateway', 'coolingDevices', 'patterns'));
    }

    public function export()
    {
        return Excel::download(new SplitsExport(), 'لیست اسپلیت ها.xlsx');
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
         try {
             $coolingDevice->delete();
             return redirect(route('coolingDevices.index', 0))->with('message', 'حذف با موفقیت انجام شد.')->with('type', 'success');
         } catch (\Exception $exception) {
             return redirect(route('coolingDevices.index', 0))->with('message', 'در حال حاضر امکان حذف وجود ندارد.')->with('type', 'danger');
         }
    }

    public function history($id)
    {
        $device = CoolingDevice::find($id);
        $histories = CoolingDeviceHistory::where('cooling_device_id', $id)->orderBy('id', 'desc')->take(300)->get();
        return view('coolingDevices.history', compact('device', 'histories'));
    }

    public function patterns(CoolingDevice $device)
    {
        // $patterns = CoolingDevicePattern::where('cooling_device_id', $device->id)->get();
        // $patterns = Pattern::where('cooling_device_id', $device->id)->get();
        // $gateway = $device->gateway->id;
        $serial_number = $device->serial_number;
        $cdp = CoolingDevicePattern::where('cooling_device_id', $device->id)->first();
        $name = $cdp ? $cdp->pattern->name : 'فاقد الگوی مصرف';
        $rows = $cdp ? $cdp->pattern->rows : [];
        return view('coolingDevices.patterns', compact('serial_number', 'rows', 'name'));
    }

    public function changeStatus($deviceId)
    {
        $device = CoolingDevice::find($deviceId);
        $modes = CoolingDeviceModes::where('id','<',10)->pluck('name', 'id')->toArray();
        return view('coolingDevices.changeStatus', compact('device', 'modes'));
    }

    public function storePattern(Request $request)
    {
        try {
            CoolingDevicePattern::where('cooling_device_id', $request->device)->delete();

            if ($request->pattern > 0) {
                CoolingDevicePattern::create([
                    'cooling_device_id' => $request->device,
                    'pattern_id' => $request->pattern
                ]);
            }

            return $this->success('با موفقیت ذخیره شد.');
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    public function massStore(Request $request)
    {
        if($request->has('devicePatterns') && $request->devicePatterns != null) {
            $devicePatterns = $request->devicePatterns;
            CoolingDevicePattern::where('pattern_id', $request->pattern)->delete();
            if ($devicePatterns)
                foreach ($devicePatterns as $key => $value) {
                    CoolingDevicePattern::create([
                        'cooling_device_id' => $devicePatterns[$key],
                        'pattern_id' => $request->pattern
                    ]);
                }
        }

        return redirect(route('patterns.show', $request->pattern));
    }
}
