@extends('layouts.admin', ['pageTitle' => 'ایجاد الگو'])
@section('content')
    <style>
        .time-picker {
            background-color: lightgray;
        }
        .error {
            border:3px solid red;
            border-radius:3px;
        }
        .swal-text {
            text-align: initial;
        }
    </style>
    <div class="row" id="alarm-container" style="display: none;">
        <div class="col-lg-12">
            <div class="page-header alert alert-danger alert-dismissible show" role="alert" style="vertical-align: center">
                <span id="alert-message"></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
    <form class="form-inline">
        <div class="form-group mb-2">
            <label for="gateway">درگاه: </label>
            {!! Form::select('gateway', $gateways, $gateway, array('class' => 'form-control', 'onchange' => 'renderDevicesList()', 'placeholder' => 'انتخاب کنید...')) !!}
        </div>
        <div class="form-group mb-2">
            <label for="devicesList">دستگاه: </label>
            <select id="devicesList" name="devicesList" class="form-control">
                <option value="">انتخاب کنید...</option>
            </select>
        </div>
        <button type="button" class="btn btn-success" onclick="save()"><i class="fa fa-save"></i> ذخیره</button>
    </form>

    <br>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ساعت شروع</th>
                    <th>ساعت پایان</th>
                    <th>حالت کار</th>
                    <th>درجه</th>
                    <th>
                        <button type="button" class="btn btn-primary pull-left" onclick="add()"><i class="fa fa-plus"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody id="table-body"></tbody>
        </table>
    </div>
    <script>
        $(document).ready(function () {
            if ($("select[name=gateway]").val() > 0)
                renderDevicesList("{{$device}}");
        });

        var id=0;
        function add() {
            var row = `
                <tr id='${id}'>
                    <td><input name='start-time-${id}' type='text' class='time start form-control' /></td>
                    <td><input name='end-time-${id}' type='text' class='time end form-control' /></td>
                    <td>{!! Form::select('mode-${id}', $modes, null, array('class' => 'form-control', 'placeholder' => 'انتخاب کنید ...', 'onchange' => 'modesListChange(${id})')) !!}</td>
                    <td>{!! Form::select('degree-${id}', config('enums.degrees'), null, array('class' => 'form-control', 'disabled' => 'disabled')) !!}</td>
                    <td><button type='button' class='btn btn-danger pull-left' onclick='document.getElementById(${id}).remove()'><i class='fa fa-remove'></i></button></td>
                </tr>`;

            $("#table-body").append(row);

            var timePickerOptions = {
                className: 'time-picker',
                listWidth: 1,
                lang: {mins: ' دقیقه', hr: ' ساعت', hrs: ' ساعت'},
                show2400: true,
                showDuration: true,
                step: 15,
                timeFormat: 'H:i',
            };

            $('.time').timepicker(timePickerOptions);
            var datepair = new Datepair(document.getElementById(`${id}`));

            id++;
        }

        function modesListChange(id) {
            var selected = $(`select[name=mode-${id}]`);
            if (selected.val() === "4" || selected.val() === "5") { // enable degree
                selected.parent().next().children().prop("disabled", false);
            } else { // disable degree
                selected.parent().next().children().val("");
                selected.parent().next().children().prop("disabled", true);
            }
        }

        function save() {
            var error = false, errorMessage="";
            var gateway = $("select[name=gateway]");
            if (!gateway.val()) {
                gateway.addClass('error');
                return;
            } else {
                gateway.removeClass('error');
            }

            var modes = [3, 4, 5], result = [], count = 0;
            $("#table-body tr").each(function (index) {
                count++;
                $(this).removeClass('error');

                var id = $(this).attr("id"),
                    start = $(`input[name=start-time-${id}]`).val(),
                    end = $(`input[name=end-time-${id}]`).val(),
                    mode = $(`select[name=mode-${id}]`).val(),
                    degree = $(`input[name=degree-${id}]`).val();


                if (!start || !end || !mode) {
                    $(this).addClass('error');
                    error = true;
                    return;
                }

                if (modes.includes(mode) && !degree) {
                    $(this).addClass('error');
                    error = true;
                    return;
                }

                // check if start or end not between other starts and ends
                for (var z=0; z<result.length; z++) {
                    console.log(start, result[z].start);
                    console.log(end, result[z].end);
                    if ((start > result[z].start && start < result[z].end) || (end > result[z].start && end < result[z].end)) {
                        $(this).addClass('error');
                        error = true;
                        errorMessage = "همزمانی بین ساعت ها رخ داده است.";
                        return;
                    }
                }

                result.push({start, end, mode, degree});
            });

            if (count > 0) {
                if (error) {
                    if (errorMessage.length > 0)
                        swal(errorMessage, "", "warning");

                    return;
                } else {
                    swal({
                        title: "هشدار",
                        text: "در صورت وجود الگوی مصرف برای این دستگاه ها، الگوی مصرف قبلی کاملا از بین رفته و الگوی جدید جایگزین می شود.\nآیا ادامه می دهید؟",
                        icon: "warning",
                        buttons: ["انصراف", "ادامه می دهم"],
                        dangerMode: false,
                    }).then((willProceed) => {
                        if (willProceed) {
                            $.ajax('/admin/patterns/store', {
                                method: 'post',
                                data: {
                                    _token: "{{csrf_token()}}",
                                    gateway: gateway.val(),
                                    device: $("#devicesList").val(),
                                    data: JSON.stringify(result)
                                },
                                success: function (response) {
                                    if (response.status === 1) {
                                        $("#alarm-container").css({"display":"flex"});
                                        $(".alert-dismissible").removeClass('alert-danger');
                                        $(".alert-dismissible").addClass('alert-success');
                                        $("#alert-message").text(response.message);
                                        // window.location.href = "/coolingDevices/id/patterns";
                                    } else {
                                        $(".row").css({"visibility":"visible"});
                                        $(".alert-dismissible").removeClass('alert-success');
                                        $(".alert-dismissible").addClass('alert-danger');
                                        $("#alert-message").text(response.message);
                                    }
                                }
                            });
                        }
                    });
                }
            } else {
                swal("هیچ ردیفی درج نشده است.", "", "warning");
            }
        }

        function renderDevicesList(selectedId=null) {
            var gateway = $("select[name=gateway]").val();
            $.ajax(`/admin/getDevicesList/${gateway}`, {
                method: 'get',
                success: function (response) {
                    clearDropDown();

                    if (response.data.length > 0) {
                        $("#devicesList").append(`<option value="">همه دستگاه های این درگاه</option>`);
                        for (var i = 0; i < response.data.length; i++) {
                            var selected = selectedId === response.data[i]['id'].toString() ? "selected" : "",
                                item = `<option value=${response.data[i]['id']} ${selected}>${response.data[i]['serial_number']}</option>`;
                            $("#devicesList").append(item);
                        }
                    } else {
                        $("#devicesList").append(`<option value="">انتخاب کنید...</option>`);
                    }
                }
            });
        }

        function clearDropDown() {
            var select = document.getElementById("devicesList");
            for (var i = select.options.length - 1; i >= 0; i--) {
                select.options[i] = null;
            }
        }
    </script>
@endsection
