<?php

namespace App\Http\Controllers;

use App\Gateway;
use App\Pattern;
use App\PatternRow;
use Illuminate\Http\Request;

class PumpPatternController extends Controller
{
    public function index()
    {
        $patterns = Pattern::where('pattern_type',3)->get();
        return view('patterns.pumps.index', compact('patterns'));
    }

    public function create()
    {
        return view('patterns.pumps.create');
    }

    public function store(Request $request)
    {
        // dd($request);

        try {
            if (strlen($request->data) > 5) {
                $pattern = new Pattern([
                    'name' => $request->name,
                    'pattern_type' => 3 // pump
                ]);
                $pattern->save();

                foreach (json_decode($request->data) as $item) {
                    PatternRow::create([
                        'pattern_id' => $pattern->id,
                        'start_time' => $item->start,
                        'relay_status' => $item->status
                    ]);
                }
                return $this->success('الگوی مصرف با موفقیت ذخیره شد.');
            } else {
                return $this->fail("ردیفی درج نشده است.");
            }
        } catch (\Exception $exception) {
            return $this->fail($exception->getLine().': '.$exception->getMessage());
        }
    }

    public function show($pattern)
    {
        $pattern = Pattern::find($pattern);
        $rows = $pattern->rows()->get();
        $pumps = Gateway::where('gateway_type',3)->get();
        return view('patterns.pumps.show', compact('pattern', 'rows','pumps'));
    }

    public function edit(Pattern $pattern)
    {
        //
    }

    public function update(Request $request, Pattern $pattern)
    {
        //
    }

    public function destroy($pattern)
    {
        try {
            $pattern = Pattern::find($pattern);
            $pattern->rows()->delete();
            $pattern->gatewayPatterns()->delete();
            $pattern->delete();

            return redirect(route('pumpPatterns.index'))->with('message', 'حذف با موفقیت انجام شد.')->with('type', 'success');
        } catch (\Exception $exception) {
            return redirect(route('pumpPatterns.index'))->with('message', $exception->getMessage())->with('type', 'success');
        }
    }

    public function massStore()
    {

    }
}
