@extends('layouts.admin', ['pageTitle' => 'ایجاد گروه', 'newButton' => false])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">مشخصات گروه</div>
        <div class="panel-body">
            {!! Form::model($group, array('route' => array('groups.update', $group), 'method' => 'PUT')) !!}
            @csrf
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">نام</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name" name="name" value="{{$group->name}}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="group_type" class="col-sm-2 control-label">نوع گروه</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="group_type" name="group_type" value="{{config('enums.group_type.'.$group->group_type)}}" disabled>
                    </div>
                </div>
                @if($group->group_type == 1)
                <div class="form-group" id="gateways-list">
                    <label for="gateways" class="col-sm-2 control-label">درگاه</label>
                    <div class="col-sm-4">
                        <select name="gateways[]" multiple style="height: 200px;" class="form-control">
                            <option value="">انتخاب کنید...</option>
                            @foreach($gateways as $gateway)
                                <option value="{{$gateway->id}}" @if(in_array($gateway->id, $allocatedGateways, true)) selected="selected" @endif>{{$gateway->serial_number}}</option>
                            @endforeach
                        </select>
                        <div class="help-block">
                            دکمه Ctrl را پایین نگه دارید و چند مورد را انتخاب کنید
                        </div>
                    </div>
                </div>
                @elseif($group->group_type == 2)
                <div class="form-group" id="devices-list">
                    <label for="devices" class="col-sm-2 control-label">دستگاه های سرمایشی</label>
                    <div class="col-sm-4">
                        <select name="devices[]" multiple style="height: 200px;" class="form-control">
                            <option value="">انتخاب کنید...</option>
                            @foreach($devices as $device)
                                <option value="{{$device->id}}" @if(in_array($device->id, $allocatedDevices, true)) selected="selected" @endif>{{$device->serial_number}} - {{$device->name}}</option>
                            @endforeach
                        </select>
                        <div class="help-block">
                            دکمه Ctrl را پایین نگه دارید و چند مورد را انتخاب کنید
                        </div>
                    </div>
                </div>
                @else
                    <div></div>
                @endif
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4 text-left">
                        <a class="btn btn-default" href="{{route('groups.index')}}">انصراف</a>
                        <button type="submit" class="btn btn-success">ذخیره</button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
