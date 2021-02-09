@extends('layouts.admin', ['pageTitle' => 'ویرایش نوع اسپلیت'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">ویرایش نوع اسپلیت</div>
        <div class="panel-body">
            {{ Form::model($coolingDeviceType, array('route' => array('coolingDeviceTypes.update', $coolingDeviceType), 'method' => 'PUT')) }}
            @csrf
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="manufacturer" class="col-sm-2 control-label">کارخانه سازنده</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="manufacturer" name="manufacturer" value="{{$coolingDeviceType->manufacturer}}" required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="model" class="col-sm-2 control-label">مدل</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="model" name="model" value="{{$coolingDeviceType->model}}" required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="warm_current" class="col-sm-2 control-label">جریان فاز گرمادهی</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="warm_current" name="warm_current" value="{{$coolingDeviceType->warm_current}}" required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="cool_current" class="col-sm-2 control-label">جریان فاز سرمادهی</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="cool_current" name="cool_current" value="{{$coolingDeviceType->cool_current}}" required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="fan_current" class="col-sm-2 control-label">جریان فاز فن</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="fan_current" name="fan_current" value="{{$coolingDeviceType->fan_current}}" required />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4 text-left">
                        <a class="btn btn-default" href="{{route('coolingDeviceTypes.index')}}">انصراف</a>
                        <button type="submit" class="btn btn-success">ذخیره</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
