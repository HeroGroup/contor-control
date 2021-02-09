<?php

namespace App\Http\Controllers;

use App\CoolingDeviceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CodeController extends Controller
{
    public function index()
    {
        $coolingDeviceTypes  = CoolingDeviceType::selectRaw('CONCAT(manufacturer, " - ", model) as model, id')->pluck('model','id')->toArray();
        return view('codes.index', compact('coolingDeviceTypes'));
    }

    public function store(Request $request)
    {
        // dd($request);
        if ($request->has('cooling_device_type_id')) {
            DB::table('ir_codes')->where('cooling_device_type_id', $request->cooling_device_type_id)->delete();
            if ($request->has('cool_normal')) {
                foreach($request->cool_normal as $key => $value) {
                    if ($value && $value != null) {
                        DB::table('ir_codes')->insert([
                            'cooling_device_type_id' => $request->cooling_device_type_id,
                            'degree' => $key,
                            'mode' => 'cool',
                            'status' => 'normal',
                            'code' => $value
                        ]);
                    }
                }
            }
            if ($request->has('cool_off')) {
                foreach($request->cool_off as $key => $value) {
                    if ($value && $value != null) {
                        DB::table('ir_codes')->insert([
                            'cooling_device_type_id' => $request->cooling_device_type_id,
                            'degree' => $key,
                            'mode' => 'cool',
                            'status' => 'off',
                            'code' => $value
                        ]);
                    }
                }
            }
            if ($request->has('cool_on')) {
                foreach($request->cool_on as $key => $value) {
                    if ($value && $value != null) {
                        DB::table('ir_codes')->insert([
                            'cooling_device_type_id' => $request->cooling_device_type_id,
                            'degree' => $key,
                            'mode' => 'cool',
                            'status' => 'on',
                            'code' => $value
                        ]);
                    }
                }
            }
            if ($request->has('warm_normal')) {
                foreach($request->warm_normal as $key => $value) {
                    if ($value && $value != null) {
                        DB::table('ir_codes')->insert([
                            'cooling_device_type_id' => $request->cooling_device_type_id,
                            'degree' => $key,
                            'mode' => 'warm',
                            'status' => 'normal',
                            'code' => $value
                        ]);
                    }
                }
            }
            if ($request->has('warm_off')) {
                foreach($request->warm_off as $key => $value) {
                    if ($value && $value != null) {
                        DB::table('ir_codes')->insert([
                            'cooling_device_type_id' => $request->cooling_device_type_id,
                            'degree' => $key,
                            'mode' => 'warm',
                            'status' => 'off',
                            'code' => $value
                        ]);
                    }
                }
            }
            if ($request->has('warm_on')) {
                foreach($request->warm_on as $key => $value) {
                    if ($value && $value != null) {
                        DB::table('ir_codes')->insert([
                            'cooling_device_type_id' => $request->cooling_device_type_id,
                            'degree' => $key,
                            'mode' => 'warm',
                            'status' => 'on',
                            'code' => $value
                        ]);
                    }
                }
            }
            if ($request->has('fan_normal')) {
                foreach($request->fan_normal as $key => $value) {
                    if ($value && $value != null) {
                        DB::table('ir_codes')->insert([
                            'cooling_device_type_id' => $request->cooling_device_type_id,
                            'degree' => $key,
                            'mode' => 'fan',
                            'status' => 'normal',
                            'code' => $value
                        ]);
                    }
                }
            }
            if ($request->has('fan_off')) {
                foreach($request->fan_off as $key => $value) {
                    if ($value && $value != null) {
                        DB::table('ir_codes')->insert([
                            'cooling_device_type_id' => $request->cooling_device_type_id,
                            'degree' => $key,
                            'mode' => 'fan',
                            'status' => 'off',
                            'code' => $value
                        ]);
                    }
                }
            }
            if ($request->has('fan_on')) {
                foreach($request->fan_on as $key => $value) {
                    if ($value && $value != null) {
                        DB::table('ir_codes')->insert([
                            'cooling_device_type_id' => $request->cooling_device_type_id,
                            'degree' => $key,
                            'mode' => 'fan',
                            'status' => 'on',
                            'code' => $value
                        ]);
                    }
                }
            }

            return redirect()->back()->with('message', 'ذخیره سازی با موفقیت انجام شد.')->with('type', 'success');
        } else {
            return redirect()->back()->with('message', 'نوع اسپلیت نامعتبر')->with('type', 'danger');
        }
    }

    public function getCodes($coolingDeviceTypeId)
    {
        try {
            $codes = DB::table('ir_codes')->where('cooling_device_type_id', $coolingDeviceTypeId)->get();
            return $this->success('codes retrieved successfully', $codes);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }
}
