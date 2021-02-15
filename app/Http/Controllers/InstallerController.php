<?php

namespace App\Http\Controllers;

use App\City;
use App\Province;
use Illuminate\Http\Request;

class InstallerController extends Controller
{
    public function newGatewayTypeB()
    {
        $provinces = Province::pluck('name','id')->toArray();
        $cities = City::pluck('name','id')->toArray();
        return view('installer.newGatewayTypeB', compact('provinces', 'cities'));
    }

    public function storeGatewayTypeB(Request $request)
    {
        $result = "12345678";
        $resultLabel = "شماره سریال کنترلر جدید";
        return view('installer.result', compact('result', 'resultLabel'));
    }

    public function newGatewayTypeA()
    {
        return view('installer.newGatewayTypeA');
    }

    public function storeGatewayTypeA(Request $request)
    {
        $result = "12345678";
        $resultLabel = "شماره سریال کنترلر جدید";
        return view('installer.result', compact('result', 'resultLabel'));
    }

    public function newSplit()
    {
        return view('installer.newSplit');
    }

    public function storeSplit(Request $request)
    {
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
