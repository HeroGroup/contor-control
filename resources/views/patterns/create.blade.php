@extends('layouts.admin', ['pageTitle' => 'الگوها'])
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
    <div class="row">
        <div class="col-lg-12 text-left">
            <button class="btn btn-success" onclick="save()"><i class="fa fa-save"></i> ثبت</button>
        </div>
    </div>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>نام الگو</th>
                <th>حداکثر جریان</th>
                <th>کارکرد (دقیقه) در حداکثر جریان</th>
                <th>دقایق قطع</th>
                <th>
                    <button type="button" class="btn btn-primary pull-left" onclick="add()"><i class="fa fa-plus"></i></button>
                </th>
            </tr>
            </thead>
            <tbody id="table-body"></tbody>
        </table>
    </div>
    <script>
        var id=0;
        function add() {
            var row = `
                <tr id='${id}'>
                    <td><input name='pattern_name_${id}' type='text' class='form-control' /></td>
                    <td><input name='max_current_${id}' type='text' class='form-control' /></td>
                    <td><input name='minutes_after_${id}' type='text' class='form-control' /></td>
                    <td><input name='off_minutes_${id}' type='text' class='form-control' placeholder="تا پایان روز"/></td>
                    <td><button type='button' class='btn btn-danger pull-left' onclick='document.getElementById(${id}).remove()'><i class='fa fa-remove'></i></button></td>
                </tr>`;

            $("#table-body").append(row);

            id++;
        }

        function remove() {
            // pass
        }

        function save() {
            var error = false;

            var result = [], count = 0;
            $("#table-body tr").each(function (index) {
                count++;
                console.log(count);
                $(this).removeClass('error');

                var id = $(this).attr("id"),
                    pattern_name = $(`input[name=pattern_name_${id}]`).val(),
                    max_current = $(`input[name=max_current_${id}]`).val(),
                    minutes_after = $(`input[name=minutes_after_${id}]`).val(),
                    off_minutes = $(`input[name=off_minutes_${id}]`).val();

                if (!pattern_name || !max_current || !minutes_after || !off_minutes) {
                    $(this).addClass('error');
                    error = true;
                    return;
                } else {
                    result.push({pattern_name, max_current, minutes_after, off_minutes});
                }
            });

            if (count > 0) {
                if (!error) {
                    $.ajax('/admin/patterns/store', {
                        method: 'post',
                        data: {
                            _token: "{{csrf_token()}}",
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
            } else {
                swal("هیچ ردیفی درج نشده است.", "", "warning");
            }
        }

    </script>
@endsection
