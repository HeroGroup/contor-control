<?php

namespace App\Http\Controllers;

use App\ElectricalMeter;
use App\ElectricalMeterHistory;
use App\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $electricalMeters = ElectricalMeter::pluck('serial_number', 'id')->toArray();
        $gateways = Gateway::pluck('serial_number', 'id')->toArray();
        $listParvande = ElectricalMeter::whereNotNull('parvande')->pluck('parvande', 'id')->toArray();
        $listShenase = ElectricalMeter::whereNotNull('shenase_moshtarak')->pluck('shenase_moshtarak', 'id')->toArray();
        return view('reports', compact('electricalMeters', 'gateways', 'listParvande', 'listShenase'));
    }

    public function report(Request $request)
    {
        $electricalMeters = ElectricalMeter::pluck('serial_number', 'id')->toArray();
        $gateways = Gateway::pluck('serial_number', 'id')->toArray();
        $listParvande = ElectricalMeter::whereNotNull('parvande')->pluck('parvande', 'id')->toArray();
        $listShenase = ElectricalMeter::whereNotNull('shenase_moshtarak')->pluck('shenase_moshtarak', 'id')->toArray();
        $shenase_moshtarak = $request->shenase_moshtarak;
        $parvande = $request->parvande;
        $electrical_meter_id = $request->electrical_meter_id;
        $gateway_id = $request->gateway_id;

        switch ($request->report_type) {
            case 1:
                $from = explode('/', $request->date_from);
                $to = explode('/', $request->date_to);
                $fromDate = $request->date_from ? str_replace(" ", "", jalali_to_gregorian($from[0], $from[1], $from[2], ' - ')) : "";
                $toDate = $request->date_to ? str_replace(" ", "", jalali_to_gregorian($to[0], $to[1], $to[2], ' - ')) : "";
                $date_from = $request->date_from;
                $date_to = $request->date_to;
                $input = 0;

                if($request->has('shenase_moshtarak') && $request->shenase_moshtarak > 0)
                    $input = $request->shenase_moshtarak;
                else if($request->has('parvande') && $request->parvande > 0)
                    $input = $request->parvande;
                else if($request->has('electrical_meter_id') && $request->electrical_meter_id > 0)
                    $input = $request->electrical_meter_id;
                else if($request->has('gateway_id'))
                    $input = ElectricalMeter::where('gateway_id',$request->gateway_id)->first()->id;

                $result = DB::table('electrical_meter_histories')
                    ->where('electrical_meter_id', $input)
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->get();

                return view('reports', compact('electricalMeters', 'gateways', 'listShenase', 'listParvande', 'shenase_moshtarak', 'parvande', 'electrical_meter_id', 'gateway_id', 'result', 'date_from', 'date_to'));

                break;

            default:
                return redirect(route('reports'));
                break;
        }
    }

    public function reportOld(Request $request)
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

    public function hist(Request $request)
    {
        // get report based on single counter, region, city
        if ($request->has('serial_number')) {
            DB::table('electrical_meter_histories')->select('parameter_values')->get();
        }
    }

    public function newReport(Request $request)
    {
        dd($request);
    }
}
