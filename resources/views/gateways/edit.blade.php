@extends('layouts.admin', ['pageTitle' => 'ویرایش درگاه'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">ویرایش درگاه</div>
        <div class="panel-body">
            <div class="form-horizontal">
                {!! Form::model($gateway, array('route' => array('gateways.update', $gateway), 'method' => 'PUT')) !!}
                <div class="form-group">
                    <label for="serial_number" class="col-sm-2 control-label">شماره سریال</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="serial_number" name="serial_number" value="{{$gateway->serial_number}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="gateway_id" class="col-sm-2 control-label">درگاه اصلی</label>
                    <div class="col-sm-4">
                        {!! Form::select('gateway_id', $gateways, $gateway->gateway_id, array('class' => 'form-control', 'id' => 'gateway_id', 'placeholder' => 'درگاه اصلی را انتخاب کنید...')) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="send_data_duration_seconds" class="col-sm-2 control-label">بازه زمانی ارسال اطلاعات (ثانیه)</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="send_data_duration_seconds" name="send_data_duration_seconds" value="{{$gateway->send_data_duration_seconds}}">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4 text-left">
                        <a class="btn btn-default" href="{{route('gateways.index')}}">انصراف</a>
                        <button type="submit" class="btn btn-success">ذخیره</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
