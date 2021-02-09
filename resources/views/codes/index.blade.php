@extends('layouts.admin', ['pageTitle' => 'کدهای اسپلیت', 'newButton' => false])
@section('content')
    <form method="post" action="/admin/codes">
        <div class="form-horizontal">
            <label class="control-label col-sm-2 text-left">نوع اسپلیت</label>
            <div class="col-sm-3">
                {!! Form::select('cooling_device_type_id', $coolingDeviceTypes, null, array('class' => 'form-control', 'id' => 'cooling_device_type_id', 'placeholder' => 'انتخاب کنید...', 'required' => 'required')) !!}
                <div id="cooling_device_type_id_required" class="help-block" style="color:red;display: none;">نوع اسپلیت را انتخاب کنید</div>
            </div>
            <label class="control-label col-sm-3" style="text-align: right;">
                <a href="{{route('coolingDeviceTypes.create')}}">اسپلیت مورد نظر در لیست نبود</a>
            </label>
            <button type="button" class="btn btn-primary" onclick="createRawTable()">شروع</button>
        </div>
        <br>
        <hr />

        @csrf
        <div id="table" class="table-responsive"></div>
    </form>
    <script>
        $("#cooling_device_type_id").on("change", function () {
            if ($(this).val() > 0) {
                deactivateCoolingDeviceTypeIdRequired();
            } else {
                activeateCoolingDeviceTypeIdRequired();
            }
        });

        function activeateCoolingDeviceTypeIdRequired() {
            $("#cooling_device_type_id_required").css({"display":"block"});
            $("#cooling_device_type_id").css({"border":"2px solid red"});
        }

        function deactivateCoolingDeviceTypeIdRequired() {
            $("#cooling_device_type_id_required").css({"display":"none"});
            $("#cooling_device_type_id").css({"border":"1px solid lightgray"});
        }
        function createRawTable(params=null) {
            var coolingDeviceTypeId = $("#cooling_device_type_id").val();
            if (coolingDeviceTypeId > 0) {
                $("#table").html("");
                var child =
                    `<table class="table table-bordered">
                    <thead>
                        <th>درجه</th>
                        <th>COOL - NORMAL</th>
                        <th>COOL - OFF</th>
                        <th>COOL - ON</th>
                        <th>WARM - NORMAL</th>
                        <th>WARM - OFF</th>
                        <th>WARM - ON</th>
                        <th>FAN - NORMAL</th>
                        <th>FAN - OFF</th>
                        <th>FAN - ON</th>
                    </thead>
                <tbody>`;
                for (var i = 16; i <= 30; i++) {
                    child +=
                        `<tr>
                        <td>DEGREE${i}</td>
                        <td><input type='text' name='cool_normal[${i}]' id='cool_normal_${i}' class='form-control' /></td>
                        <td><input type='text' name='cool_off[${i}]' id='cool_off_${i}' class='form-control' /></td>
                        <td><input type='text' name='cool_on[${i}]' id='cool_on_${i}' class='form-control' /></td>
                        <td><input type='text' name='warm_normal[${i}]' id='warm_normal_${i}' class='form-control' /></td>
                        <td><input type='text' name='warm_off[${i}]' id='warm_off_${i}' class='form-control' /></td>
                        <td><input type='text' name='warm_on[${i}]' id='warm_on_${i}' class='form-control' /></td>
                        <td><input type='text' name='fan_normal[${i}]' id='fan_normal_${i}' class='form-control' /></td>
                        <td><input type='text' name='fan_off[${i}]' id='fan_off_${i}' class='form-control' /></td>
                        <td><input type='text' name='fan_on[${i}]' id='fan_on_${i}' class='form-control' /></td>
                    </tr>`;
                }

                var fan = {0: 'AUTO', 1: 'HIGH', 2: 'MEDIUM', 3: 'LOW'};

                for (var j = 0; j < 4; j++) {
                    child +=
                        `<tr>
                        <td>${fan[j]}</td>
                        <td><input type='text' name='cool_normal[${fan[j]}]' id='cool_normal_${fan[j]}' class='form-control' /></td>
                        <td><input type='text' name='cool_off[${fan[j]}]' id='cool_off_${fan[j]}' class='form-control' /></td>
                        <td><input type='text' name='cool_on[${fan[j]}]' id='cool_on_${fan[j]}' class='form-control' /></td>
                        <td><input type='text' name='warm_normal[${fan[j]}]' id='warm_normal_${fan[j]}' class='form-control' /></td>
                        <td><input type='text' name='warm_off[${fan[j]}]' id='warm_off_${fan[j]}' class='form-control' /></td>
                        <td><input type='text' name='warm_on[${fan[j]}]' id='warm_on_${fan[j]}' class='form-control' /></td>
                        <td><input type='text' name='fan_normal[${fan[j]}]' id='fan_normal_${fan[j]}' class='form-control' /></td>
                        <td><input type='text' name='fan_off[${fan[j]}]' id='fan_off_${fan[j]}' class='form-control' /></td>
                        <td><input type='text' name='fan_on[${fan[j]}]' id='fan_on_${fan[j]}' class='form-control' /></td>
                    </tr>`;
                }

                child += `</tbody></table><hr /><button type="submit" class="btn btn-success"" style="float:left;margin-bottom:20px;">ذخیره کدها</button>` ;
                $("#table").append(child);

                $.ajax("/admin/getCodes/"+coolingDeviceTypeId, {
                    type: "get",
                    success: function(response) {
                        if(response && response.data) {
                            var rdata = response.data;
                            if (rdata.length > 0) {
                                for (var i = 0; i < rdata.length; i++) {
                                    var id = `${rdata[i].mode}_${rdata[i].status}_${rdata[i].degree}`;
                                    $(`#${id}`).val(rdata[i].code);
                                }
                            }
                        }
                    }
                })
            } else {
                activeateCoolingDeviceTypeIdRequired();
            }
        }
    </script>
@endsection
