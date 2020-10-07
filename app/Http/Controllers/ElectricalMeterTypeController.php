<?php

namespace App\Http\Controllers;

use App\ElectricalMeterType;
use Illuminate\Http\Request;

class ElectricalMeterTypeController extends Controller
{
    public function index()
    {
        $electricalMeterTypes = ElectricalMeterType::all();
        return view('electricalMeterTypes.index', compact('electricalMeterTypes'));
    }

    public function create()
    {
        return view('electricalMeterTypes.create');
    }

    public function store(Request $request)
    {
        ElectricalMeterType::create($request->all());
        return redirect('admin/electricalMeterTypes')->with('message', 'نوع دستگاه با موفقیت ایجاد شد');
    }

    public function edit(ElectricalMeterType $electricalMeterType)
    {
        return view('electricalMeterTypes.edit', compact('electricalMeterType'));
    }

    public function update(Request $request, ElectricalMeterType $electricalMeterType)
    {
        $electricalMeterType->update($request->all());
        return redirect('admin/electricalMeterTypes')->with('message', 'نوع دستگاه با موفقیت بروزرسانی شد');
    }

    public function destroy(ElectricalMeterType $electricalMeterType)
    {
        $electricalMeterType->delete();
        return redirect('admin/electricalMeterTypes')->with('message', 'نوع دستگاه با موفقیت حذف شد');
    }
}
