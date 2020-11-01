@extends('layouts.admin', ['pageTitle' => 'ایجاد الگوی جدید'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">درگاه جدید</div>
        <div class="panel-body">
            {{ Form::open(array('url' => route('gateways.patterns.store'), 'method' => 'POST')) }}
            @csrf
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">نام الگو</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="max_current" class="col-sm-2 control-label">حداکثر جریان (آمپر)</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="max_current" name="max_current" value="{{old('max_current')}}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="minutes_after" class="col-sm-2 control-label">حداکثر زمان (دقیقه)</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="minutes_after" name="minutes_after" value="{{old('minutes_after')}}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="off_minutes" class="col-sm-2 control-label">دقایق قطع</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="off_minutes" name="off_minutes" value="{{old('off_minutes')}}">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4 text-left">
                        <a class="btn btn-default" href="{{route('gateways.patterns.index')}}">انصراف</a>
                        <button type="submit" class="btn btn-success">ذخیره</button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
