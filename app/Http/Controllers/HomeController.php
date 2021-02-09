<?php

namespace App\Http\Controllers;

use App\CoolingDevice;
use App\CoolingDeviceType;
use App\Gateway;
use App\ModifyContor;
use App\User;
use App\UserGateway;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {
        $userGateways = UserGateway::where('user_id',auth()->id())->select('gateway_id')->get();
        $typeAGateways = Gateway::whereIn('id', $userGateways)->where('gateway_type', 1)->count();
        $splitControllers = Gateway::whereIn('id', $userGateways)->where('gateway_type', 2)->count();
        $pumpGateways = Gateway::whereIn('id', $userGateways)->where('gateway_type', 3)->count();
        $totalSplits = CoolingDevice::whereIn('gateway_id', $userGateways)->count();
        return view('dashboard', compact('typeAGateways', 'splitControllers', 'pumpGateways', 'totalSplits'));
    }

    public function randomFillModify()
    {
        try {
            $coolingDevices = [1, 2, 3, 4, 5];
            $gatewayId = 1;
            $relay = [1, 3, 4, 5];
            $degree = [17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30];
            for ($i = 0; $i < 1000; $i++) {
                $r1 = $relay[array_rand($relay)];
                $r2 = ($r1 == 3 || $r1 == 4) ? $degree[array_rand($degree)] : 0;
                ModifyContor::create([
                    'gateway_id' => $gatewayId,
                    'cooling_device_id' => $coolingDevices[array_rand($coolingDevices)],
                    'relay1_status' => $r1,
                    'relay2_status' => $r2,
                    'checked' => 0
                ]);
            }
            return $this->success("1000 rows inserted successfully");
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    public function redirectUserToProperPage()
    {
        $user = auth()->user();
        if ($user) {
            if ($user->hasRole('installer')) {
                return redirect('/home');
            } else {
                return redirect('/admin/dashboard');
            }
        } else {
            return redirect('/login');
        }
    }
/*
    public function convertHistories()
    {
        try {
            $histories = ElectricalMeterHistory::orderBy('id', 'asc')->get()->toArray();
            for ($i = 0; $i < count($histories); $i += 12) {
                $e = $histories[$i]['electrical_meter_id'];
                $str = "";
                $c = $histories[$i]['created_at'];
                for ($j = 0; $j < 12; $j++)
                    $str .= ($histories[$i + $j]['parameter_value'] . '&');

                DB::insert("INSERT INTO e_m_h_test(electrical_meter_id,parameter_values,created_at) VALUES(?,?,?)",[$e,$str,$c]);
            }
            return $this->success("converted successfully.");
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    public function getCurrent()
    {
        try {
            $data = DB::table('e_m_h_test')->select('id', 'parameter_values')->get();
            foreach ($data as $datum) {
                $id = $datum->id;
                $result = explode('&',$datum->parameter_values);
                $current = $result[9] ? $result[9] : null;
                DB::table('e_m_h_test')->where('id',$id)->update(['current' => $current]);
            }
            return $this->success("converted successfully.");
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }
*/

}
