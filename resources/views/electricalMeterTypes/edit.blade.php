@extends('layouts.admin', ['pageTitle' => 'ویرایش نوع دستگاه'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">ویرایش نوع دستگاه</div>
        <div class="panel-body">
            <div class="form-horizontal">
                {!! Form::model($electricalMeterType, array('route' => array('electricalMeterTypes.update', $electricalMeterType), 'method' => 'PUT')) !!}
                <div class="form-group">
                    <label for="manufacturer" class="col-sm-2 control-label">شرکت سازنده</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="manufacturer" name="manufacturer" value="{{$electricalMeterType->manufacturer}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="model" class="col-sm-2 control-label">مدل</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="model" name="model" value="{{$electricalMeterType->model}}">
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
