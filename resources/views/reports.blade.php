@extends('layouts.admin', ['pageTitle' => 'گزارشات', 'newButton' => false])
@section('content')
    <style>
        .parameters {
            display: none;
        }
        .error {
            border-color: red;
            border-width: 2px;
        }
    </style>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <div class="col-lg-3">
                        <input type="radio" id="daily_demand" name="report_type" value="daily_demand">
                        <label for="daily_demand" class="control-label">گزارش دیماند روزانه</label>
                    </div>

                    <label for="date_from" class="col-lg-1 control-label parameters daily_demand_parameters">از تاریخ</label>
                    <div class="col-lg-2 parameters daily_demand_parameters">
                        <input type="text" name="date_from" class="custom_date_picker date_from form-control" />
                    </div>

                    <label for="date_to" class="col-lg-1 control-label parameters daily_demand_parameters">تا تاریخ</label>
                    <div class="col-lg-2 parameters daily_demand_parameters">
                        <input type="text" name="date_to" class="custom_date_picker date_to form-control" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-3">
                        <input type="radio" id="hourly_demand" name="report_type" value="hourly_demand">
                        <label for="hourly_demand" class="control-label">گزارش دیماند ساعتی</label>
                    </div>
                    <label for="date_daily" class="col-lg-1 control-label parameters hourly_demand_parameters">تاریخ</label>
                    <div class="col-lg-2">
                        <input type="text" name="date_daily" class="custom_date_picker form-control parameters hourly_demand_parameters" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-12">
                        <button class="btn btn-success" onclick="getReport()">تهیه گزارش</button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <p id="report-required" style="color: red; visibility: hidden;" >انتخاب نوع گزارش الزامیست.</p>
            </div>
        </div>
    </div>

    <script>
        var reportRequired = $("#report-required");

        $("input[name=report_type]").change(function() {
            reportRequired.css({ "visibility" : "hidden" });
            var report = $("input[name=report_type]:checked").val();
            $(".parameters").hide();
            $(`.${report}_parameters`).show();
        });

        function getReport() {
            var report = $("input[name=report_type]:checked").val(), parameters;
            switch (report) {
                case 'daily_demand':
                    var dateFrom = $("input[name=date_from]"),
                        dateTo = $("input[name=date_to]");
                    if (!dateFrom.val() || !dateTo.val()) {
                        dateFrom.addClass("error");
                        dateTo.addClass("error");
                        return;
                    } else {
                        dateFrom.removeClass("error");
                        dateTo.removeClass("error");
                        if (dateFrom.val() < dateTo.val()) {
                            parameters = {
                                "from": dateFrom.val(),
                                "to": dateTo.val()
                            };
                        } else {
                            swal("تاریخ شروع باید از تاریخ پایان کوچکتر باشد.");
                        }
                    }
                    break;
                case 'hourly_demand':
                    var dateDaily = $("input[name=date_daily]");
                    if(!dateDaily.val()) {
                        dateDaily.addClass("error");
                        return;
                    } else {
                        dateDaily.removeClass("error");
                        parameters = {
                            "date": dateDaily.val()
                        };
                    }
                    break;
                default:
                    reportRequired.css({ "visibility" : "visible" });
                    break;
            }

            if (parameters) {

                $.ajax("/admin/report", {
                    type: "post",
                    data: {
                        "_token": "{{csrf_token()}}",
                        "report": report,
                        "parameters": parameters
                    }
                });

            }
        }
    </script>
@endsection
