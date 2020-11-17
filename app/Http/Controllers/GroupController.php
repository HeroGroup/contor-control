<?php

namespace App\Http\Controllers;

use App\CoolingDevice;
use App\CoolingDevicePattern;
use App\Gateway;
use App\GatewayPattern;
use App\Group;
use App\GroupPattern;
use App\GroupRow;
use App\Pattern;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        $patterns = Pattern::where('pattern_type', 1)->pluck('name', 'id')->toArray();
        return view('groups.index', compact('groups', 'patterns'));
    }

   public function create()
    {
        // pass gateways and cooling devices with no groups or patterns
        $groupGateways = GroupRow::whereNotNull('gateway_id')->select('gateway_id')->distinct()->get();
        $patternGateways = GatewayPattern::select('gateway_id')->distinct()->get();
        $gateways = Gateway::whereNotIn('id', $groupGateways)->whereNotIn('id', $patternGateways)->get();

        $groupCoolingDevices = GroupRow::whereNotNull('cooling_device_id')->select('cooling_device_id')->distinct()->get();
        $patternCoolingDevices = CoolingDevicePattern::select('cooling_device_id')->distinct()->get();
        $devices = CoolingDevice::whereNotIn('id',$groupCoolingDevices)->whereNotIn('id',$patternCoolingDevices)->get();

        return view('groups.create',compact('gateways', 'devices'));
    }

    public function store(Request $request)
    {
        $group = new Group([
            'name' => $request->name,
            'group_type' => $request->group_type,
        ]);
        $group->save();

        if ($request->has('gateways') && count($request->gateways) > 0) {
            //dd($request->gateways);
            $gateways = $request->gateways;
            for($i=0; $i<count($gateways); $i++) {
                GroupRow::create([
                    'group_id' => $group->id,
                    'gateway_id' => $gateways[$i]
                ]);
            }
        }

        if ($request->has('devices') && count($request->devices) > 0) {
            $devices = $request->devices;
            for($i=0; $i<count($devices); $i++) {
                GroupRow::create([
                    'group_id' => $group->id,
                    'cooling_device_id' => $devices[$i]
                ]);
            }
        }

        return redirect(route('groups.index'))->with('message', 'ثبت گروه با موفقیت انجام شد.')->with('type', 'success');
    }

    public function show(Group $group)
    {
        //
    }

    public function edit(Group $group)
    {
        $ag = GroupRow::where('group_id', $group->id)->get();
        $ad = GroupRow::where('cooling_device_id', $group->id)->get();

        $allocatedGateways = [];
        if ($ag->count() > 0)
            foreach ($ag as $allocatedGateway)
                array_push($allocatedGateways, $allocatedGateway->gateway_id);

        $allocatedDevices = [];
        if ($ad->count() > 0)
            foreach ($ad as $allocatedDevice)
                array_push($allocatedDevices, $allocatedDevice->cooling_device_id);

        $groupGateways = GroupRow::whereNotNull('gateway_id')->where('group_id','!=',$group->id)->select('gateway_id')->distinct()->get();
        $patternGateways = GatewayPattern::select('gateway_id')->distinct()->get();
        $gateways = Gateway::whereNotIn('id', $groupGateways)->whereNotIn('id', $patternGateways)->get();

        $groupCoolingDevices = GroupRow::whereNotNull('cooling_device_id')->where('group_id','!=',$group->id)->select('cooling_device_id')->distinct()->get();
        $patternCoolingDevices = CoolingDevicePattern::select('cooling_device_id')->distinct()->get();
        $devices = CoolingDevice::whereNotIn('id',$groupCoolingDevices)->whereNotIn('id',$patternCoolingDevices)->get();

        return view('groups.edit', compact('group', 'allocatedGateways', 'allocatedDevices', 'gateways', 'devices'));
    }

    public function update(Request $request, Group $group)
    {
        if ($request->has('gateways') && count($request->gateways) > 0) {
            // delete all rows and create again
            GroupRow::where('group_id',$group->id)->whereNotNull('gateway_id')->delete();
            $gateways = $request->gateways;
            for($i=0; $i<count($gateways); $i++) {
                GroupRow::create([
                    'group_id' => $group->id,
                    'gateway_id' => $gateways[$i]
                ]);
            }
        }
        if ($request->has('devices') && count($request->devices) > 0) {
            // delete all rows and create again
            GroupRow::where('group_id',$group->id)->whereNotNull('cooling_device_id')->delete();
            $devices = $request->devices;
            for($i=0; $i<count($devices); $i++) {
                GroupRow::create([
                    'group_id' => $group->id,
                    'cooling_device_id' => $devices[$i]
                ]);
            }
        }

        return redirect(route('groups.index'))->with('message', 'تغییرات با موفقیت ذخیره شد.')->with('type', 'success');
    }

    public function destroy(Group $group)
    {
        GroupRow::where('group_id', $group->id)->delete();
        $group->delete();
        return redirect(route('groups.index'))->with('message', 'حذف با موفقیت انجام شد.')->with('type', 'success');
    }

    public function groupGatewayPattern(Group $group)
    {
        $groupPatterns = GroupPattern::where('group_id', $group->id)->get();
        $patterns = Pattern::where('pattern_type',2)->pluck('name','id')->toArray();
        return view('groups.gatewayPattern', compact('group','groupPatterns','patterns'));
    }

    public function storeGatewayGroupPatterns(Request $request)
    {
        try {
            foreach (json_decode($request->data) as $item) {
                GroupPattern::create([
                    'group_id' => $request->group,
                    'pattern_id' => $item
                ]);
            }
            return $this->success("با موفقیت ذخیره شد.");

        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    public function removeSingleGatewayGroupPattern(Request $request)
    {
        try {
            GroupPattern::find($request->id)->delete();
            return $this->success('حذف با موفقیت انجام شد.');
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    public function storeDeviceGroupPattern(Request $request)
    {
        try {
            GroupPattern::where('group_id', $request->group)->delete();

            if ($request->pattern > 0) {
                GroupPattern::create([
                    'group_id' => $request->group,
                    'pattern_id' => $request->pattern
                ]);
            }

            return $this->success('با موفقیت ذخیره شد.');
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }
}

