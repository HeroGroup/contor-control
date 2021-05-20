<?php

namespace App\Http\Controllers;

use App\City;
use App\ElectricalMeter;
use App\Gateway;
use App\Province;
use Illuminate\Http\Request;

class InstallerController extends Controller
{
    public function storeNewGatewayTrait($contorSerial,$requestProvince,$requestCity,$simCardNum,$type,$parent=null)
    {
        $gateway = new Gateway([
            'gateway_id' => $parent,
            'serial_number' => $contorSerial,
            'city_id' => $requestCity,
            'sim_card_number' => $simCardNum,
            'version' => 'V2'
        ]);
        $gateway->save();

        $electricalMeter = new ElectricalMeter([
            'gateway_id' => $gateway->id,
            'unique_id' => strval(intval(ElectricalMeter::max('unique_id'))+1),
            'serial_number' => $contorSerial,
        ]);
        $electricalMeter->save();

        $province = Province::find($requestProvince);
        $city = City::find($requestCity);

        $gatewayId = $gateway->id;
        for($i=strlen($gateway->id);$i<3;$i++) { // add zero before gateway id
            $gatewayId = '0'.$gatewayId;
        }

        $result = $province->province_code . $city->city_code . '00' . $type . $gatewayId . '000' . '000'; // province + city + district + device type + gateway id + meter id + split
        $gateway->update(['serial_number' => $result]);

        return $result;
    }

    public function newGatewayTypeB()
    {
        $provinces = Province::pluck('name','id')->toArray();
        $cities = City::pluck('name','id')->toArray();
        return view('installer.newGatewayTypeB', compact('provinces', 'cities'));
    }

    public function storeGatewayTypeB(Request $request)
    {
        $result = $this->storeNewGatewayTrait($request->contor_serial_number,$request->province,$request->city,$request->simCardNum,'3');
        $resultLabel = "شماره سریال کنترلر جدید";
        return view('installer.result', compact('result', 'resultLabel'));
    }

    public function newGatewayTypeA()
    {
        return view('installer.newGatewayTypeA');
    }

    public function storeGatewayTypeA(Request $request)
    {
        dd($request);

        $parent = Gateway::where('serial_number','LIKE',$request->gateway_id)->first();

        $gateway = new Gateway([
            'gateway_id' => $parent->gateway_id,
            'serial_number' => $request->contor_serial_number,
            'version' => 'V2'
        ]);
        $gateway->save();

        $electricalMeter = new ElectricalMeter([
            'gateway_id' => $gateway->id,
            'unique_id' => strval(intval(ElectricalMeter::max('unique_id'))+1),
            'serial_number' => $request->contor_serial_number,
        ]);
        $electricalMeter->save();

        $province = Province::find($request->province);
        $city = City::find($request->city);

        $gatewayId = $gateway->id;
        for($i=strlen($gateway->id);$i<3;$i++) { // add zero before gateway id
            $gatewayId = '0'.$gatewayId;
        }

        $result = $province->province_code . $city->city_code . '00' . '2' . $gatewayId . '000' . '000'; // province + city + district + device type + gateway id + meter id + split
        $gateway->update(['serial_number' => $result]);

        $resultLabel = "شماره سریال کنترلر جدید";
        return view('installer.result', compact('result', 'resultLabel'));
    }

    public function newSplit()
    {
        return view('installer.newSplit');
    }

    public function storeSplit(Request $request)
    {
        dd($request);
        $result = "12345678";
        $resultLabel = "شماره سریال اسپلیت جدید";
        return view('installer.result', compact('result', 'resultLabel'));
    }

    public function editProfile()
    {
        return view('installer.userProfile');
    }

    public function updateProfile(Request $request)
    {
        //
    }

    public function mqtt()
    {
        return view('mqtt.test');
    }

}
