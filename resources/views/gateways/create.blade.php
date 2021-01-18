@extends('layouts.admin', ['pageTitle' => 'ایجاد کنترلر کنتور'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">کنترلر کنتور جدید</div>
        <div class="panel-body">
            {{ Form::open(array('url' => route('gateways.store'), 'method' => 'POST')) }}
            @csrf
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="serial_number" class="col-sm-2 control-label">شناسه دستگاه</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="serial_number" name="serial_number" value="{{old('serial_number')}}" required maxlength="10">
                    </div>
                </div>

                <div class="form-group">
                    <label for="gateway_id" class="col-sm-2 control-label">کنترلر اصلی</label>
                    <div class="col-sm-4">
                        {!! Form::select('gateway_id', $gateways, old('gateway_id'), array('class' => 'form-control', 'id' => 'gateway_id', 'placeholder' => 'کنترلر اصلی را انتخاب کنید...')) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="send_data_duration_seconds" class="col-sm-2 control-label">بازه زمانی ارسال اطلاعات (ثانیه)</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="send_data_duration_seconds" name="send_data_duration_seconds" value="{{old('send_data_duration_seconds')}}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="meter_serial_number" class="col-sm-2 control-label">شماره سریال کنتور</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="meter_serial_number" name="meter_serial_number" value="{{old('meter_serial_number')}}" required maxlength="14">
                    </div>
                </div>

                <div class="form-group">
                    <label for="model" class="col-sm-2 control-label">مدل کنتور</label>
                    <div class="col-sm-4">
                        {!! Form::select('model', $electricalMeterTypes, old('model'), array('class' => 'form-control', 'id' => 'model', 'placeholder' => 'مدل کنتور را انتخاب کنید...')) !!}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4 text-left">
                        <a class="btn btn-default" href="{{route('gateways.index')}}">انصراف</a>
                        <button type="submit" class="btn btn-success">ذخیره</button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
