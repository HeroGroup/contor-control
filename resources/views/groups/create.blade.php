@extends('layouts.admin', ['pageTitle' => 'ایجاد گروه', 'newButton' => false])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">مشخصات گروه</div>
        <div class="panel-body">
            {{ Form::open(array('url' => route('groups.store'), 'method' => 'POST')) }}
            @csrf
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">نام</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="group_type" class="col-sm-2 control-label">نوع گروه</label>
                    <div class="col-sm-4">
                        {!! Form::select('group_type', config('enums.group_type'), old('group_type'), array('class' => 'form-control', 'placeholder' => 'انتخاب کنید...', 'onchange' => 'changeGroupType()')) !!}
                    </div>
                </div>
                <div class="form-group" id="gateways-list" style="display:none;">
                    <label for="gateways" class="col-sm-2 control-label">درگاه</label>
                    <div class="col-sm-4">
                        <select name="gateways[]" multiple style="height: 200px;" class="form-control">
                            <option value="">انتخاب کنید...</option>
                            @foreach($gateways as $gateway)
                                <option value="{{$gateway->id}}">{{$gateway->serial_number}}</option>
                            @endforeach
                        </select>
                        <div class="help-block">
                            دکمه Ctrl را پایین نگه دارید و چند گزینه را انتخاب کنید
                        </div>
                    </div>
                </div>
                <div class="form-group" id="devices-list" style="display:none;">
                    <label for="devices" class="col-sm-2 control-label">دستگاه های سرمایشی</label>
                    <div class="col-sm-4">
                        <select name="devices[]" multiple style="height: 200px;" class="form-control">
                            <option value="">انتخاب کنید...</option>
                            @foreach($devices as $device)
                                <option value="{{$device->id}}">{{$device->serial_number}} - {{$device->name}}</option>
                            @endforeach
                        </select>
                        <div class="help-block">
                            دکمه Ctrl را پایین نگه دارید و چند گزینه را انتخاب کنید
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4 text-left">
                        <a class="btn btn-default" href="{{route('groups.index')}}">انصراف</a>
                        <button type="submit" class="btn btn-success">ذخیره</button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <script>
        function changeGroupType() {
            var selected = $("select[name=group_type]").val();
            if (selected == 1) {
                $("#gateways-list").css({"display":"flex"});
                $("#devices-list").css({"display":"none"});
            } else if (selected == 2) {
                $("#devices-list").css({"display":"flex"});
                $("#gateways-list").css({"display":"none"});
            } else {
                $("#devices-list").css({"display":"none"});
                $("#gateways-list").css({"display":"none"});
            }
        }
    </script>
@endsection
