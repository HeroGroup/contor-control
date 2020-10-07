<?php

namespace App\Http\Controllers;

use App\ElectricalMeter;
use App\Gateway;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;

class AdminGatewayController extends Controller
{
    public function index()
    {
        $gateways = Gateway::all();
        return view('gateways.index', compact('gateways'));
    }

    public function create()
    {
        $gateways = Gateway::pluck('serial_number', 'id')->toArray();
        return view('gateways.create', compact('gateways'));
    }

    public function store(Request $request)
    {
        $gateway = new Gateway($request->all());
        $gateway->save();
        ElectricalMeter::create([
            'gateway_id' => $gateway->id,
            'unique_id' => strval(intval(ElectricalMeter::max('unique_id'))+1),
            'serial_number' => strval(intval(ElectricalMeter::max('serial_number'))+1),
            'electrical_meter_type_id' => 1,
            'phase' => 1,
            'relay1_status' => 0,
            'relay2_status' => 0,
        ]);

        return redirect('admin/gateways')->with('message', 'درگاه (gateway) با موفقیت ایجاد شد')->with('type', 'success');
    }

    public function edit(Gateway $gateway)
    {
        $children = Gateway::where('gateway_id', $gateway->id)->get();
        $gateways = Gateway::where('id', '!=', $gateway->id)->whereNotIn('id', $children)->pluck('serial_number', 'id')->toArray();
        return view('gateways.edit', compact('gateway', 'gateways'));
    }

    public function update(Request $request, Gateway $gateway)
    {
        $gateway->update($request->all());
        return redirect('admin/gateways')->with('message', 'درگاه با موفقیت بروزرسانی شد');
    }

    public function destroy(Gateway $gateway)
    {
        // todo checke dependencies
        // $gateway->delete();
        return redirect('admin/gateways')->with('message', 'در حال حاضر امکان حذف وجود ندارد')->with('type', 'danger');
    }

    public function devices(Gateway $gateway)
    {
        return redirect(route('coolingDevices.index', $gateway));
    }
}
