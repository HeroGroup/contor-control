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
                    <label for="customer_name" class="col-sm-2 control-label">نام مشترک</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{old('customer_name')}}" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="customer_address" class="col-sm-2 control-label">آدرس مشترک</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="customer_address" name="customer_address" value="{{old('customer_address')}}" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="parvande" class="col-sm-2 control-label">شماره پرونده</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="parvande" name="parvande" value="{{old('parvande')}}" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="shenase_moshtarak" class="col-sm-2 control-label">شناسه مشترک</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="shenase_moshtarak" name="shenase_moshtarak" value="{{old('shenase_moshtarak')}}" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="gateway_type" class="col-sm-2 control-label">نوع کنترلر</label>
                    <div class="col-sm-4">
                        {!! Form::select('gateway_type', config('enums.gateway_type'), old('gateway_type'), array('class' => 'form-control', 'id' => 'gateway_type', 'placeholder' => 'نوع کنترلر را انتخاب کنید...')) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="city_id" class="col-sm-2 control-label">شهر</label>
                    <div class="col-sm-4">
                        {!! Form::select('city_id', $cities, old('city_id'), array('class' => 'form-control', 'id' => 'city_id', 'placeholder' => 'شهر کنترلر انتخاب کنید...')) !!}
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
