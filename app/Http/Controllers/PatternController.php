<?php

namespace App\Http\Controllers;

use App\CoolingDevice;
use App\CoolingDeviceModes;
use App\CoolingDevicePattern;
use App\Gateway;
use App\Pattern;
use App\GatewayPattern;
use App\PatternRow;
use Illuminate\Http\Request;

class PatternController extends Controller
{
    public function index()
    {
        $patterns = Pattern::where('pattern_type', 1)->get();
        return view('patterns.index', compact('patterns'));
    }

    public function getDevices($gateway=null)
    {
        if (!$gateway || $gateway=='') {
            return $this->success('success', []);
        } else {
            $devices = CoolingDevice::where('gateway_id', $gateway)->get(['id', 'serial_number']);
            return $this->success('success', $devices);
        }
    }

    public function create()
    {
        return view('patterns.create');
    }

    public function show(Pattern $pattern)
    {
        $allocated = CoolingDevicePattern::where('pattern_id', '!=', $pattern->id)->get(['cooling_device_id']);

        $devices = CoolingDevice::whereNotIn('id', $allocated)->get();
        $rows = PatternRow::where('pattern_id', $pattern->id)->orderBy('id', 'asc')->get();
        return view('patterns.show', compact('rows', 'pattern', 'devices'));
    }

    public function destroyRow(PatternRow $row)
    {
        $pattern = $row->pattern_id;
        $row->delete();
        return redirect(route('patterns.show', $pattern))->with('message', 'حذف با موفقیت انجام شد.')->with('type', 'success');
    }

    public function destroy(Pattern $pattern)
    {
        // delete all rows
        // delete all associated coolingDevicePatterns
        return redirect(route('patterns.index'))->with('message', 'در حال حاضر امکان حذف وجود ندارد.')->with('type', 'danger');
    }

    public function createCoolingDevicePattern($gateway=null, $device=null)
    {
        $gateways = Gateway::pluck('serial_number', 'id')->toArray();
        $modes = CoolingDeviceModes::pluck('name', 'id')->toArray();
        return view('patterns.createCoolingDevicePattern',compact('gateways', 'modes', 'gateway', 'device'));
    }

    public function gatewayPatternsIndex()
    {
        $patterns = Pattern::where('pattern_type', 2)->get();
        return view('patterns.gatewayPatterns', compact('patterns'));
    }

    public function createGatewayPattern()
    {
        return view('patterns.createGatewayPattern');
    }

    public function storeGatewayPattern(Request $request)
    {
//        try {
//            $pattern = GatewayPattern::where('gateway_id', $request->gateway_id)->first();
//            if ($pattern) // update
//                $pattern->update($request->toArray());
//            else // create new
//                GatewayPattern::create($request->toArray());
//
//            return $this->success("success");
//        } catch (\Exception $exception) {
//            return $this->fail($exception->getMessage());
//        }
        $pattern = new Pattern([
            'name' => $request->name,
            'pattern_type' => 2,
        ]);
        $pattern->save();

        PatternRow::create([
            'pattern_id' => $pattern->id,
            'max_current' => $request->max_current,
            'minutes_after' => $request->minutes_after,
            'relay_status' => 0,
            'off_minutes' => $request->off_minutes
        ]);
        return redirect(route('gateways.patterns.index'));
    }

    public function massStore(Request $request)
    {
        try {
            foreach (json_decode($request->data) as $item) {
                GatewayPattern::create([
                    'gateway_id' => $request->gateway,
                    'pattern_id' => $item
                ]);
            }
            return $this->success("با موفقیت ذخیره شد.");

        } catch (\Exception $exception) {
            return fail($exception->getMessage());
        }
    }

    public function destroyGatewayPattern(Pattern $pattern)
    {
        return redirect(route('gateways.patterns.index'))->with('message', 'در حال حاضر امکان حذف وجود ندارد.')->with('type', 'danger');
    }

    public function destroySingleGatewayPattern($gateway, $pattern)
    {
        try {
            $gp = GatewayPattern::find($pattern);
            $gp->delete();
            return $this->success('با موفقیت حذف شد.');
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    public function storeCoolingDevicePattern(Request $request)
    {
        try {
            $pattern = new Pattern([
                'name' => $request->name,
                'pattern_type' => 1 // cooling device
            ]);
            $pattern->save();

            foreach (json_decode($request->data) as $item) {
                PatternRow::create([
                    'pattern_id' => $pattern->id,
                    'start_time' => $item->start,
                    'end_time' => $item->end,
                    'mode_id' => $item->mode,
                    'degree' => $item->degree
                ]);
            }

            return $this->success('الگوی مصرف با موفقیت ذخیره شد.');
        } catch (\Exception $exception) {
            return $this->fail($exception->getLine().': '.$exception->getMessage());
        }
    }

    public function storeCoolingDevicePatternDeprecated(Request $request)
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

    public function checkNameUniqueness(Request $request)
    {
        //
    }
}
