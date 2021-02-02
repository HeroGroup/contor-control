@extends('layouts.admin', ['pageTitle' => 'ایجاد الگوی خاموش/روشن پمپ'])
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
            <label for="name">نام الگو: </label>
            <input type="text" name="name" id="name" class="form-control" />
        </div>

        <button type="button" class="btn btn-success" onclick="save()"><i class="fa fa-save"></i> ذخیره</button>
    </form>

    <br>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ساعت شروع</th>
                <th>وضعیت</th>
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
                    <td><input name='start-time-${id}' type='text' class='time start form-control' /></td>
                    <td>{!! Form::select('status-${id}', config('enums.relay_status'), null, array('class' => 'form-control', 'placeholder' => 'انتخاب کنید ...')) !!}</td>
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

        function save() {
            var error = false, errorMessage="";
            var name = $("#name");
            if (!name.val()) {
                name.addClass('error');
                return;
            } else {
                name.removeClass('error');
            }

            var modes = [3, 4], result = [], count = 0;
            $("#table-body tr").each(function (index) {
                count++;
                $(this).removeClass('error');

                var id = $(this).attr("id"),
                    start = $(`input[name=start-time-${id}]`).val(),
                    status = $(`select[name=status-${id}]`).val();


                if (!start || !status) {
                    $(this).addClass('error');
                    error = true;
                    return;
                }

                result.push({start, status});
            });

            if (count > 0) {
                if (error) {
                    if (errorMessage.length > 0)
                        swal(errorMessage, "", "warning");

                    return;
                } else {
                    $.ajax('/admin/pumpPatterns', {
                        method: 'post',
                        data: {
                            _token: "{{csrf_token()}}",
                            name: name.val(),
                            data: JSON.stringify(result)
                        },
                        success: function (response) {
                            if (response.status === 1) {
                                swal({
                                    title: "",
                                    text: response.message,
                                    type: "success"
                                }).then(function() {
                                    window.location.href = "{{route('pumpPatterns.index')}}";
                                });
                            } else {
                                $("#alarm-container").css({"display":"flex"});
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
