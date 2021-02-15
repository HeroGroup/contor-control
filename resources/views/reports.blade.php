@extends('layouts.admin', ['pageTitle' => 'گزارشات', 'newButton' => false])
@section('content')
    <script src="/js/selectize.min.js"></script>
    <link rel="stylesheet" href="/css/selectize.bootstrap3.min.css" />
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
            <form method="post" action="{{route('reports.post')}}">
                @csrf
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="shenase_moshtarak">شناسه مشترک</label>
                            <input type="text" name="shenase_moshtarak" id="shenase_moshtarak" value="{{isset($shenase_moshtarak) ? $shenase_moshtarak : ""}}" class="form-control" />
                        </div>
                        <div class="col-sm-2">
                            <label for="parvande">شماره پرونده</label>
                            <input type="text" name="parvande" id="parvande" value="{{isset($parvande) ? $parvande : ""}}" class="form-control" />
                        </div>
                        <div class="col-sm-2">
                            <label for="electrical_meter_id">سریال کنتور</label>
                            {!! Form::select('electrical_meter_id', $electricalMeters, isset($electrical_meter_id) ? $electrical_meter_id : null, array('class' => 'form-control', 'placeholder' => 'انتخاب کنید...')) !!}
                        </div>
                        <div class="col-sm-2">
                            <label for="gateway_id" >شناسه کنترلر</label>
                            {!! Form::select('gateway_id', $gateways, isset($gateway_id) ? $gateway_id : null, array('class' => 'form-control', 'placeholder' => 'انتخاب کنید...')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="date_from">از تاریخ</label>
                            <input type="text" name="date_from" id="date_from" value="{{isset($date_from) ? $date_from : ""}}" class="custom_date_picker date_from form-control" />
                        </div>
                        <div class="col-sm-2">
                            <label for="date_to">تا تاریخ</label>
                            <input type="text" name="date_to" id="date_to" value="{{isset($date_to) ? $date_to : ""}}" class="custom_date_picker date_to form-control" />
                        </div>
                        <div class="col-sm-2">
                            <label for="report_type" >نوع گزارش</label>
                            <select name="report_type" id="report_type">
                                <option value="1">پروفیل بار مصرفی</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-success text-right" style="margin-top:25px;">تهیه گزارش</button>
                            <button type="button" class="btn btn-info text-left" style="margin-top:25px;" disabled>خروجی اکسل</button>
                        </div>
                    </div>
                    <!-- <div class="form-group">
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
                    </div> -->

                </div>

                <div class="form-group">
                    <p id="report-required" style="color: red; visibility: hidden;" >انتخاب نوع گزارش الزامیست.</p>
                </div>

                <div id="result">
                    @if (isset($result))
                        @if($result->count() == 0)
                            <h5 style="color:gray;text-align:center;">در این بازه تاریخی رکوردی وجود ندارد</h5>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>تاریخ</th>
                                    <th>ساعت</th>
                                    <th>سریال کنتور</th>
                                    <th>پرونده</th>
                                    <th>توان مصرفی</th>
                                    <th>جریان فاز 1</th>
                                    <th>جریان فاز 2</th>
                                    <th>جریان فاز 3</th>
                                    <th>ولتاژ فاز 1</th>
                                    <th>ولتاژ فاز 2</th>
                                    <th>ولتاژ فاز 3</th>
                                    <th>انرژی تعرفه 1</th>
                                    <th>انرژی تعرفه 2</th>
                                    <th>انرژی تعرفه 3</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php $i=1; ?>
                                @foreach($result as $resultItem)
                                    <?php $items = explode('&', $resultItem->parameter_values); ?>
                                    @if(strlen($items[2]) > 0)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>
                                                <?php
                                                if(strlen($items[2]) > 8)
                                                    $temp = substr_replace(substr($items[2],0,8), '/', 4, 0);
                                                else
                                                    $temp = substr_replace($items[2], '/', 4, 0);
                                                ?>
                                                {{ strlen($temp > 2) ? substr_replace($temp, '/', 7, 0) : "" }}
                                            </td>
                                            <td>
                                                <?php
                                                if(strlen($items[3]) > 6)
                                                    echo substr_replace(substr($items[3],8,4), ':', 2, 0);
                                                else
                                                    echo substr_replace($items[3], ':', 2, 0);
                                                ?>
                                            </td>
                                            <td>{{$items[1]}}</td>
                                            <td></td>
                                            <td>{{$items[4]}}</td>
                                            <td>{{$items[10]}}</td>
                                            <td></td>
                                            <td></td>
                                            <td>{{$items[9]}}</td>
                                            <td></td>
                                            <td></td>
                                            <td>{{$items[5]}}</td>
                                            <td>{{$items[6]}}</td>
                                            <td>{{$items[7]}}</td>
                                        </tr>
                                        <?php $i++; ?>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('select').selectize({
                sortField: 'text'
            });
        });

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
