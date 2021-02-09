<?php

namespace App\Http\Controllers;

use App\CoolingDeviceType;
use Illuminate\Http\Request;

class CoolingDeviceTypeController extends Controller
{
    public function index()
    {
        $coolingDeviceTypes = CoolingDeviceType::all();
        return view('coolingDeviceTypes.index', compact('coolingDeviceTypes'));
    }

    public function create()
    {
        return view('coolingDeviceTypes.create');
    }

    public function store(Request $request)
    {
        try {
            CoolingDeviceType::create($request->all());
            return redirect()->back()->with('message', 'ذخیره سازی با موفقیت انجام شد.')->with('type', 'success');
        } catch (\Exception $exception) {
            return redirect()->back()->with('message', $exception->getMessage())->with('type', 'danger');
        }
    }

    public function edit(CoolingDeviceType $coolingDeviceType)
    {
        return view('coolingDeviceTypes.edit', compact('coolingDeviceType'));
    }

    public function update(Request $request, CoolingDeviceType $coolingDeviceType)
    {
        try {
            $coolingDeviceType->update($request->all());
            return redirect(route('coolingDeviceTypes.index'))->with('message', 'بروزرسانی با موفقیت انجام شد.')->with('type', 'success');
        } catch (\Exception $exception) {
            return redirect(route('coolingDeviceTypes.index'))->with('message', $exception->getMessage())->with('type', 'danger');
        }
    }

    public function destroy(CoolingDeviceType $coolingDeviceType)
    {
        try {
            $coolingDeviceType->delete();
            return redirect(route('coolingDeviceTypes.index'))->with('message', 'حذف با موفقیت انجام شد.')->with('type', 'success');
        } catch (\Exception $exception) {
            return redirect(route('coolingDeviceTypes.index'))->with('message', $exception->getMessage())->with('type', 'danger');
        }
    }
}
