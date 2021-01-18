@extends('layouts.admin', ['pageTitle' => 'ویرایش دستگاه'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">ویرایش دستگاه</div>
        <div class="panel-body">
            <div class="form-horizontal">
                {!! Form::model($coolingDevice, array('route' => array('coolingDevices.update', $coolingDevice), 'method' => 'PUT')) !!}

                <div class="form-group">
                    <label for="serial_number" class="col-sm-2 control-label">شماره سریال</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="serial_number" name="serial_number" value="{{$coolingDevice->serial_number}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">عنوان</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name" name="name" value="{{$coolingDevice->name}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="gateway_id" class="col-lg-2 control-label">درگاه (gateway)</label>
                    <div class="col-lg-4">
                        {{Form::select('gateway_id', $gateways, $coolingDevice->gateway_id, ['name'=>'gateway_id', 'placeholder' => 'انتخاب کنید...', 'class' => 'form-control'])}}
                    </div>
                </div>

                <div class="form-group">
                    <label for="remote_manufacturer" class="col-lg-2 control-label">تولید کننده دستگاه</label>
                    <div class="col-lg-4">
                        {{Form::select('remote_manufacturer', config('enums.remote_manufacturers'), $coolingDevice->remote_manufacturers, ['name'=>'remote_manufacturer', 'class' => 'form-control'])}}
                    </div>
                </div>

                <div class="form-group">
                    <label for="rf_broadcast_enable" class="col-lg-2 control-label">Broadcast Enabled</label>
                    <div class="col-lg-4">
                        {{Form::select('rf_broadcast_enable', config('enums.enabled'), $coolingDevice->rf_broadcast_enable, ['name'=>'rf_broadcast_enable', 'placeholder' => 'انتخاب کنید...', 'class' => 'form-control'])}}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4 text-left">
                        <a class="btn btn-default" href="{{route('coolingDevices.index', 0)}}">انصراف</a>
                        <button type="submit" class="btn btn-success">ذخیره</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
