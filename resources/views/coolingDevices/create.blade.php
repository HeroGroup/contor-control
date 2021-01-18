@extends('layouts.admin', ['pageTitle' => 'ایجاد دستگاه'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">دستگاه جدید</div>
        <div class="panel-body">
            {{ Form::open(array('url' => route('coolingDevices.store'), 'method' => 'POST')) }}
            @csrf
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="serial_number" class="col-sm-2 control-label">شماره سریال</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="serial_number" name="serial_number" value="{{old('serial_number')}}" placeholder="شماره سریال" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">عنوان</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" placeholder="اتاق کنفرانس، دفتر مدیر عامل، ...">
                    </div>
                </div>

                <div class="form-group">
                    <label for="gateway_id" class="col-lg-2 control-label">درگاه (gateway)</label>
                    <div class="col-lg-4">
                        {{Form::select('gateway_id', $gateways, $gateway, ['name'=>'gateway_id', 'placeholder' => 'انتخاب درگاه...', 'class' => 'form-control', 'required' => 'required'])}}
                    </div>
                </div>

                <div class="form-group">
                    <label for="remote_manufacturer" class="col-lg-2 control-label">تولید کننده دستگاه</label>
                    <div class="col-lg-4">
                        {{Form::select('remote_manufacturer', config('enums.remote_manufacturers'), null, ['name'=>'remote_manufacturer', 'class' => 'form-control'])}}
                    </div>
                </div>

                <div class="form-group">
                    <label for="rf_broadcast_enable" class="col-lg-2 control-label">Broadcast Enabled</label>
                    <div class="col-lg-4">
                        {{Form::select('rf_broadcast_enable', config('enums.enabled'), '1', ['name'=>'rf_broadcast_enable', 'class' => 'form-control'])}}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4 text-left">
                        <a class="btn btn-default" href="{{route('coolingDevices.index', 0)}}">انصراف</a>
                        <button type="submit" class="btn btn-success">ذخیره</button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
