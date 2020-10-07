@extends('layouts.admin', ['pageTitle' => 'ویرایش دستگاه'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">ویرایش دستگاه</div>
        <div class="panel-body">
            <div class="form-horizontal">
                {!! Form::model($electricalMeter, array('route' => array('electricalMeterTypes.update', $electricalMeter), 'method' => 'PUT')) !!}
                <div class="form-group">
                    <label for="unique_id" class="col-sm-2 control-label">شماره شناسایی</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="unique_id" name="unique_id" value="{{$electricalMeter->unique_id}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="serial_number" class="col-sm-2 control-label">شماره سریال</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="serial_number" name="serial_number" value="{{$electricalMeter->serial_number}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="gateway_id" class="col-lg-2 control-label">درگاه (gateway)</label>
                    <div class="col-lg-4">
                        {{Form::select('gateway_id', $gateways, $electricalMeter->gateway_id, ['name'=>'gateway_id', 'placeholder' => 'انتخاب کنید...', 'class' => 'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="electrical_meter_type_id" class="col-lg-2 control-label">نوع</label>
                    <div class="col-lg-4">
                        {{Form::select('electrical_meter_type_id', $models, $electricalMeter->electrical_meter_type_id, ['name'=>'electrical_meter_type_id', 'placeholder' => 'انتخاب کنید...', 'class' => 'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4 text-left">
                        <a class="btn btn-default" href="{{route('electricalMeterTypes.index')}}">انصراف</a>
                        <button type="submit" class="btn btn-success">ذخیره</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
