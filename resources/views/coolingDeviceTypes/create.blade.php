@extends('layouts.admin', ['pageTitle' => 'ایجاد نوع اسپلیت'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">نوع اسپلیت جدید</div>
        <div class="panel-body">
            {{ Form::open(array('url' => route('coolingDeviceTypes.store'), 'method' => 'POST')) }}
            @csrf
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="manufacturer" class="col-sm-2 control-label">کارخانه سازنده</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="manufacturer" name="manufacturer" value="{{old('manufacturer')}}" required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="model" class="col-sm-2 control-label">مدل</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="model" name="model" value="{{old('model')}}" required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="number_of_phases" class="col-sm-2 control-label">تعداد فاز کولر</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="number_of_phases" name="number_of_phases" value="{{old('number_of_phases')}}" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="warm_current" class="col-sm-2 control-label">جریان فاز گرمادهی</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="warm_current" name="warm_current" value="{{old('warm_current')}}" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="cool_current" class="col-sm-2 control-label">جریان فاز سرمادهی</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="cool_current" name="cool_current" value="{{old('cool_current')}}" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="fan_current" class="col-sm-2 control-label">جریان فاز فن</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="fan_current" name="fan_current" value="{{old('fan_current')}}" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4 text-left">
                        <a class="btn btn-default" href="{{route('codes.index')}}">انصراف</a>
                        <button type="submit" class="btn btn-success">ذخیره</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
