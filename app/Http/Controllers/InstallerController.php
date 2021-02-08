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

    public function createGatewayTypeB(Request $request)
    {
        //
    }

    public function newGatewayTypeA()
    {
        return view('installer.newGatewayTypeA');
    }

    public function createGatewayTypeA(Request $request)
    {
        //
    }

    public function newSplit()
    {
        return view('installer.newSplit');
    }

    public function createSplit(Request $request)
    {
        //
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
