@extends('layouts.admin', ['pageTitle' => 'الگوی مصرف گروه  '.$group->name, 'newButton' => false])
@section('content')
    <style>
        .error {
            border:3px solid red;
            border-radius:3px;
        }
    </style>
    <div class="panel panel-default">
        <div class="panel-heading">الگوی مصرف</div>
        <div class="panel-body">
            <div style="display: flex;justify-content: left; padding-bottom: 10px;">
                <button class="btn btn-primary" onclick="addRow()"><i class="fa fa-fw fa-plus"></i></button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>نام الگو</th>
                        <th>حداکثر جریان (آمپر)</th>
                        <th>حداکثر زمان (دقیقه)</th>
                        <th>دقایق قطع</th>
                        <th>حذف</th>
                    </tr>
                    </thead>
                    <tbody id="table-body">
                    @foreach($groupPatterns as $pattern)
                        <tr>
                            <td>{{$pattern->pattern->name}}</td>
                            <td>{{$pattern->pattern->rows->first()->max_current}}</td>
                            <td>{{$pattern->pattern->rows->first()->minutes_after}}</td>
                            <td>{{$pattern->pattern->rows->first()->off_minutes}}</td>
                            <td>
                                <button class="btn btn-danger btn-xs pull-left" onclick='removeSingleItem("{{$pattern->id}}")'>
                                    <i class="fa fa-fw fa-trash"></i>
                                    حذف از این گروه
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div style="display: flex;justify-content: left; padding-bottom: 10px;">
                <button class="btn btn-success" onclick="save()"><i class="fa fa-fw fa-save"></i> ذخیره</button>
            </div>
        </div>
    </div>
    <script>
        var id = 0;
        function addRow() {
            var row = `
                <tr id='${id}'>
                    <td>{!! Form::select('patternsList-${id}', $patterns, null, array('class' => 'form-control', 'placeholder' => 'انتخاب کنید ...')) !!}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><button type='button' class='btn btn-danger pull-left' onclick='document.getElementById(${id}).remove()'><i class='fa fa-remove'></i></button></td>
                </tr>`;
            $("#table-body").append(row);
            id++;
        }

        function save() {
            var count = 0, error = false, result = [];
            $("#table-body tr").each(function (index) {

                $(this).removeClass('error');

                var id = $(this).attr("id"),
                    pattern = $(`select[name=patternsList-${id}]`);

                if (id) {
                    if (pattern.val() > 0) {
                        result.push(pattern.val());
                    } else {
                        $(this).addClass('error');
                        error = true;
                        return;
                    }
                    count++;
                }
            });

            if (count > 0) {
                $.ajax("{{route('groups.gatewayPatterns.store')}}", {
                    type: "post",
                    data: {
                        _token: "{{csrf_token()}}",
                        group: "{{$group->id}}",
                        data: JSON.stringify(result)
                    },
                    success: function (response) {
                        if (response.status === 1) {
                            swal({
                                title: "",
                                text: response.message,
                                icon: "success",
                            }).then((willProceed) => {
                                if (willProceed)
                                    window.location.reload();
                            });
                        } else {
                            swal(response.message);
                        }
                    }
                });
            }
        }

        function removeSingleItem(id) {
            swal({
                title: "آیا این ردیف حذف شود؟",
                text: "توجه داشته باشید که عملیات حذف غیر قابل بازگشت می باشد.",
                icon: "warning",
                buttons: ["انصراف", "حذف"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax("/admin/groups/patterns/removeSingle", {
                        type: "post",
                        data: {
                            _token: "{{@csrf_token()}}",
                            id: id
                        },
                        success: function(response) {
                            if (response.status === 1) {
                                window.location.reload();
                            } else {
                                swal(response.message);
                            }
                        }
                    });
                }
            });
        }
    </script>
@endsection
