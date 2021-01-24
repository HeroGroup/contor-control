<?php

namespace App\Http\Controllers;

use App\ElectricalMeter;
use App\ElectricalMeterHistory;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports');
    }

    public function report(Request $request)
    {
        // return $this->success('success', $request->all());
        // $request->device (user)
        // $request->report
        // $request->parameters // from , to
        switch ($request->report) {
            case "daily_demand":
                $from = explode("/", $request->parameters['from']);
                $from = implode("-",jalali_to_gregorian($from[0], $from[1], $from[2]));

                $to = explode("/", $request->parameters['to']);
                $to = implode("-",jalali_to_gregorian($to[0], $to[1], $to[2]));

                $id = 0;
                $electrticalMeter = ElectricalMeter::where('gateway_id', $request->parameters['device'])->first();
                if ($electrticalMeter)
                    $id = $electrticalMeter->id;
                $history = [];//ElectricalMeterHistory::where('electrical_meter_id', $id)->whereBetween('created_at', $from, $to)->get();
                dd($history);
                break;
            case "hourly_demand":
                break;
            default:
                break;
        }
    }
}
