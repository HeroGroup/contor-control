@extends('layouts.admin', ['pageTitle' => 'تغییر وضعیت دستگاه'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">تغییر وضعیت دستگاه <span>{{$device->serial_number}}</span></div>
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="mode" class="col-sm-2 control-label">حالت کار</label>
                    <div class="col-sm-4">
                        {!! Form::select('mode', $modes, $device->mode, array('class' => 'form-control', 'id' => 'mode', 'placeholder' => 'انتخاب کنید ...', 'onchange' => 'modesListChange()')) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="degree" class="col-sm-2 control-label">درجه</label>
                    <div class="col-sm-4">
                        {!! Form::select('degree', config('enums.degrees'), $device->degree, array('class' => 'form-control', 'id' => 'degree', 'required' => 'required')) !!}
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
        $(document).ready(function() {
            modesListChange();
        });

        function sendUpdateRequest() {
            var mode = $("#mode").children("option:selected").val();
            var temperature = $("#degree").val();
            if (mode === 3 || mode === 4) {
                if (! temperature > 0) {
                    swal("درجه تنظیم نشده است.");
                    return;
                }
            }

            $.ajax("{{route('updateCoolingDevice')}}", {
                type: "post",
                data: {
                    cooling_device: "{{$device->serial_number}}",
                    mode: mode,
                    temperature: temperature
                },
                success: function(response) {
                    swal({
                        title: "",
                        text: response.message,
                        type: "success"
                    }).then(function() {
                        window.history.back();// window.location.href = "{{route('coolingDevices.index', 0)}}";
                    });
                }
            })
        }

        function modesListChange() {
            var selected = $("#mode").val(), degree = $("#degree");
            if (selected === "3" || selected === "4") { // enable degree
                degree.prop("disabled", false);
            } else { // disable degree
                degree.val("");
                degree.prop("disabled", true);
            }
        }
    </script>
@endsection
