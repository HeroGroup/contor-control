<?php

namespace App\Http\Controllers;

use App\City;
use App\ElectricalMeter;
use App\ElectricalMeterHistory;
use App\ElectricalMeterType;
use App\Exports\ControllersExport;
use App\Gateway;
use App\GatewayPattern;
use App\Pattern;
use App\UserGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AdminGatewayController extends Controller
{
    public function index($type=1)
    {
        $userGateways = UserGateway::where('user_id',auth()->id())->select('gateway_id')->get();
        $gateways = Gateway::whereIn('id', $userGateways)->where('gateway_type',$type)->orderBy('serial_number', 'asc')->get();
        return view('gateways.index', compact('gateways','type'));
    }

    public function export($type=1)
    {
        $reportName = "";
        switch ($type) {
            case 1:
                $reportName = 'لیست کنترلر کنتور.xlsx';
                break;

            case 2:
                $reportName = 'لیست کنترلر بار سرمایشی.xlsx';
                break;

            case 3:
                $reportName = 'لیست کنترلر پمپ.xlsx';
                break;

            default:
                break;
        }

        return Excel::download(new ControllersExport($type), $reportName);
    }

    public function create()
    {
        $gateways = Gateway::pluck('serial_number', 'id')->toArray();
        $electricalMeterTypes = ElectricalMeterType::select(DB::raw("CONCAT(manufacturer,model) as description, id"))->pluck('description', 'id')->toArray();

        $cities = City::pluck('name', 'id')->toArray();
        return view('gateways.create', compact('gateways', 'electricalMeterTypes', 'cities'));
    }

    public function store(Request $request)
    {
        $gateway = new Gateway($request->all());
        $gateway->save();
        ElectricalMeter::create([
            'gateway_id' => $gateway->id,
            'unique_id' => strval(intval(ElectricalMeter::max('unique_id'))+1),
            'serial_number' => $request->meter_serial_number, // strval(intval(ElectricalMeter::max('serial_number'))+1),
            'sim_card_number' => $request->sim_card_number,
            'electrical_meter_type_id' => $request->model,
            'customer_name' => $request->customer_name,
            'customer_address' => $request->customer_address,
            'shenase_moshtarak' => $request->shenase_moshtarak,
            'parvande' => $request->parvande,
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
        $electricalMeterTypes = ElectricalMeterType::select(DB::raw("CONCAT(manufacturer,model) as description, id"))->pluck('description', 'id')->toArray();
        $cities = City::pluck('name', 'id')->toArray();
        return view('gateways.edit', compact('gateway', 'gateways', 'electricalMeterTypes', 'cities'));
    }

    public function update(Request $request, Gateway $gateway)
    {
        $gateway->update($request->all());
        $electricalMeter = ElectricalMeter::where('gateway_id', $gateway->id)->first();
        $electricalMeter->update([
            'serial_number' => $request->meter_serial_number,
            'sim_card_number' => $request->sim_card_number,
            'electrical_meter_type_id' => $request->model ? $request->model : null,
            'customer_name' => $request->customer_name,
            'customer_address' => $request->customer_address,
            'shenase_moshtarak' => $request->shenase_moshtarak,
            'parvande' => $request->parvande,
        ]);

        return redirect('admin/gateways')->with('message', 'درگاه با موفقیت بروزرسانی شد')->with('type', 'success');
    }

    public function destroy(Gateway $gateway)
    {
        try {
            $gateway->delete();
            return redirect('admin/gateways')->with('message', 'حذف با موفقیت انجام شد.')->with('type', 'success');
        } catch (\Exception $exception) {
            return redirect('admin/gateways')->with('message', $exception->getMessage())->with('type', 'danger');
        }
    }

    public function devices(Gateway $gateway)
    {
        return redirect(route('coolingDevices.index', $gateway));
    }

    public function patterns(Gateway $gateway)
    {
        $gatewayPatterns = GatewayPattern::where('gateway_id', $gateway->id)->orderBy('id', 'asc')->get();
        // $users = User::where('user_type' ,'LIKE', 'client')->selectRaw('id, CONCAT(mobile,\' - \',name) as info')->pluck('info', 'id')->toArray();
        $patterns = Pattern::where('pattern_type',2)->pluck('name','id')->toArray();
        return view('gateways.patterns', compact('gateway', 'gatewayPatterns','patterns'));
    }

    /*
    |----------------------------------------------------------------------------------
    | I'm going to have mixed feelings.
    | I Love my wife, and I also have feelings for RN ...
    | I'm not sure if she has feelings for me too.
    | but I'm able to gain her attention.
    | she's really sexy ... I want "No Strings Attached"
    |----------------------------------------------------------------------------------
    */

    public function getChildren($gateway)
    {
        try {
            $userGateways = UserGateway::where('user_id',auth()->id())->where('gateway_id', $gateway)->count();

            $children = [];
            if ($userGateways > 0)
                $children = Gateway::where('gateway_id', $gateway)->with('parentGateway')->with('electricalMeters')->orderBy('serial_number', 'asc')->get();

            return $this->success('data retrieved successfully', $children);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }
}
