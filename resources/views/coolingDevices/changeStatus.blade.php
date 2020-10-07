@extends('layouts.admin', ['pageTitle' => 'تغییر وضعیت دستگاه'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">تغییر وضعیت دستگاه <span>{{$device->serial_number}}</span></div>
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="mode" class="col-sm-2 control-label">حالت کار</label>
                    <div class="col-sm-4">
                        {!! Form::select('mode', $modes, $device->mode, array('class' => 'form-control', 'id' => 'mode', 'placeholder' => 'انتخاب کنید ...')) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="degree" class="col-sm-2 control-label">درجه</label>
                    <div class="col-sm-4">
                        <input type="number" name="degree" id="degree" class="form-control" value="{{$device->degree}}">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4 text-left">
                        <a class="btn btn-default" href="{{route('coolingDevices.index', 0)}}">انصراف</a>
                        <button type="button" onclick="sendUpdateRequest()" class="btn btn-success">ذخیره</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function sendUpdateRequest() {
            $.ajax("{{route('updateCoolingDevice')}}", {
                type: "post",
                data: {
                    cooling_device: "{{$device->serial_number}}",
                    mode: $("#mode").children("option:selected").val(),
                    temperature: $("#degree").val()
                },
                success: function(response) {
                    swal(response.message);
                }
            })
        }
    </script>
@endsection
