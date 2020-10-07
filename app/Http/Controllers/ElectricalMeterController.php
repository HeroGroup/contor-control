<?php

namespace App\Http\Controllers;
use App\ElectricalMeter;
use App\ElectricalMeterHistory;
use App\ElectricalMeterParameter;
use App\ElectricalMeterType;
use App\Gateway;
use Illuminate\Http\Request;

class ElectricalMeterController extends Controller
{
    public function index()
    {
        $electricalMeters = ElectricalMeter::all();
        return view('electricalMeters.index', compact('electricalMeters'));
    }

    public function create()
    {
        $gateways = Gateway::pluck('serial_number', 'id')->toArray();
        $models = ElectricalMeterType::selectRaw('id, CONCAT(manufacturer,\' - \',model) as model_info')->pluck('model_info', 'id')->toArray();
        return view('electricalMeters.create', compact('gateways', 'models'));
    }

    public function store(Request $request)
    {
        ElectricalMeter::create($request->all());
        return redirect('/admin/electricalMeters')->with('message', 'کنتور با موفقیت ایجاد شد');
    }

    public function edit($id)
    {
        $electricalMeter = ElectricalMeter::find($id);
        $gateways = Gateway::pluck('serial_number', 'id')->toArray();
        $models = ElectricalMeterType::selectRaw('id, CONCAT(manufacturer,\' - \',model) as model_info')->pluck('model_info', 'id')->toArray();
        return view('electricalMeters.edit', compact('electricalMeter', 'gateways', 'models'));
    }

    public function update(Request $request, $id)
    {
        $electricalMeter = ElectricalMeter::find($id);
        $electricalMeter->update($request->all());
        return redirect('/admin/electricalMeters')->with('message', 'کنتور با موفقیت بروزرسانی شد');
    }

    public function destroy($id)
    {
        ElectricalMeter::find($id)->delete();
        return redirect('/admin/electricalMeters')->with('message', 'کنتور با موفقیت حذف شد');
    }

    public function history($id)
    {
        $electricalMeter = ElectricalMeter::find($id);

        if ($electricalMeter) {
            $serialNumber = $electricalMeter->gateway->serial_number;
            $labels = ElectricalMeterParameter::pluck('parameter_label', 'id')->toArray();
            $histories = [];

            $checked = [];
            for($i=0; $i<14; $i++) {
                $temp = [];
                for ($j = 1; $j <= 12; $j++) {
                    $maxId = ElectricalMeterHistory::where('electrical_meter_id', $id)
                        ->where('electrical_meter_parameter_id', $j)// relay1_status
                        ->whereNotIn('id', $checked)
                        ->max('id');
                    if ($maxId) {
                        array_push($checked, $maxId);
                        $latest = ElectricalMeterHistory::find($maxId);
                        if($j == 2) { // date
                            $temp[$j] = substr_replace($latest->parameter_value, '/', 4, 0);
                            $temp[$j] = substr_replace($temp[$j], '/', 7, 0);
                        } else if($j == 3) { // time
                            $temp[$j] = substr_replace($latest->parameter_value, ':', 2, 0);
                            $temp[$j] = substr_replace($temp[$j], ':', 5, 0);
                        } else {
                            $temp[$j] = $latest->parameter_value;
                        }
                    }
                }
                // $histories[$i] = $temp;
                array_push($histories, $temp);
            }

            return view('electricalMeters.history', compact('serialNumber', 'labels', 'histories'));
        } else {
            return redirect('/admin/electricalMeters')->with('message', 'تاریخچه وجود ندارد');
        }
    }
}
