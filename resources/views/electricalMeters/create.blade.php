@extends('layouts.admin', ['pageTitle' => 'ایجاد دستگاه'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">دستگاه جدید</div>
        <div class="panel-body">
            {{ Form::open(array('url' => route('electricalMeters.store'), 'method' => 'POST')) }}
            @csrf
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="unique_id" class="col-sm-2 control-label">کد شناسایی</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="unique_id" name="unique_id" value="{{old('unique_id')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="serial_number" class="col-sm-2 control-label">شماره سریال</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="serial_number" name="serial_number" value="{{old('serial_number')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="gateway_id" class="col-lg-2 control-label">درگاه (gateway)</label>
                    <div class="col-lg-4">
                        {{Form::select('gateway_id', $gateways, null, ['name'=>'gateway_id', 'placeholder' => 'انتخاب کنید...', 'class' => 'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="electrical_meter_type_id" class="col-lg-2 control-label">نوع</label>
                    <div class="col-lg-4">
                        {{Form::select('electrical_meter_type_id', $models, null, ['name'=>'electrical_meter_type_id', 'placeholder' => 'انتخاب کنید...', 'class' => 'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4 text-left">
                        <a class="btn btn-default" href="{{route('electricalMeters.index')}}">انصراف</a>
                        <button type="submit" class="btn btn-success">ذخیره</button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
