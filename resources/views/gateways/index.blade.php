@extends('layouts.admin', ['pageTitle' => 'لیست کنترلرها', 'newButton' => true, 'newButtonUrl' => "/admin/gateways/create", 'newButtonText' => 'ایجاد کنترلر'])
@section('content')
    <style>
        @media only screen and (max-width: 767px) {
            #main-headers {
                display: none;
            }
            .col-sm-2 {
                padding:5px;
            }
            .row {
                border: 1px solid gray;
                margin:10px;
                border-radius: 5px;
            }
        }

        .col-sm-1,.col-sm-2 {
            text-align: center;
            border-left: 1px solid gray;
        }
        .col-sm-2:last-child {
            border-left: none;
        }
        .triangle {
            width: 0;
            height: 0;
            cursor: pointer;
            display: inline-block;
        }
        .triangle-left {
            border-top: 5px solid transparent;
            border-right: 10px solid #fff;
            border-bottom: 5px solid transparent;
        }
        .triangle-down {
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 10px solid #fff;
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 45px;
            height: 21px;
        }
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 15px;
            width: 15px;
            left: 6px;
            bottom: 3px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }
        input:checked + .slider {
            background-color: #2196F3;
        }
        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }
        input:checked + .slider:before {
            -webkit-transform: translateX(21px);
            -ms-transform: translateX(21px);
            transform: translateX(21px);
        }
        .slider.round {
            border-radius: 24px;
        }
        .slider.round:before {
            border-radius: 50%;
        }
    </style>
    <div class="panel panel-default">
        <div class="panel-heading">کنترلرهای کنتور</div>
        <div class="panel-body">
            <ul class="nav nav-pills">
                <li @if($type==1) class="active" @endif><a href="/admin/gateways/1">کنترلر کنتور</a></li>
                <li @if($type==2) class="active" @endif><a href="/admin/gateways/2">کنترلر بار سرمایشی</a></li>
                <li @if($type==3) class="active" @endif><a href="/admin/gateways/3">کنترلر پمپ</a></li>
            </ul>
            <hr />
            <div class="row" id="main-headers">
                <div class="col-sm-2">شماره پرونده</div>
                <div class="col-sm-1">شهر</div>
                <div class="col-sm-2">شماره سریال کنتور</div>
                <div class="col-sm-1">ارتباط</div>
                <div class="col-sm-2">وضعیت رله 1</div>
                <div class="col-sm-2">وضعیت رله 2</div>
                <div class="col-sm-2">عملیات</div>
            </div>
            <hr />
            @foreach($gateways as $gateway)
                <div class="row">
                    <div class="col-sm-2">
                        <input type="hidden" name="id" value="{{$gateway->id}}" />
                        <div class="triangle triangle-left" data-toggle="collapse" data-target="#{{$gateway->id}}-children"></div>
                        &nbsp;
                        <a href="{{route('gateways.devices',$gateway->id)}}">{{$gateway->electricalMeters->first()->parvande ? $gateway->electricalMeters->first()->parvande : $gateway->serial_number}}</a>
                    </div>
                    <div class="col-sm-1">{{$gateway->city_id ? $gateway->city->name : '-'}}</div>
                    <div class="col-sm-2">
                        {{$gateway->electricalMeters->first() ? $gateway->electricalMeters->first()->serial_number : ''}}
                    </div>
                    <div class="col-sm-1">
                        @if($gateway->electricalMeters->first()->is_active)
                            <div class="label label-success">فعال</div>
                        @else
                            <div class="label label-default">غیرفعال</div>
                        @endif
                    </div>
                    <div class="col-sm-2">
                        <span style="font-size:12px;"> روشن </span>
                        <label class="switch">
                            <input type="checkbox" @if($gateway->electricalMeters->first()->relay1_status == 1) checked @endif onchange="changeGatewayRelayStatus('{{$gateway->serial_number}}', this.checked)">
                            <span class="slider round"></span>
                        </label>
                        <span style="font-size:12px;"> خاموش </span>
                    </div>
                    <div class="col-sm-2">
                        <span style="font-size:12px;"> روشن </span>
                        <label class="switch">
                            <input type="checkbox" @if($gateway->electricalMeters->first()->relay2_status == 1) checked @endif onchange="changeGatewayRelay2Status('{{$gateway->serial_number}}', this.checked)">
                            <span class="slider round"></span>
                        </label>
                        <span style="font-size:12px;"> خاموش </span>
                    </div>
                    <div class="col-sm-2">
                        <div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                عملیات
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-left" role="menu">
                                <li>
                                    <a href="{{route('gateways.edit',$gateway->id)}}">
                                        <span class="text-warning">ویرایش</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('gateways.devices',$gateway->id)}}">
                                        <span class="text-info">دستگاه ها</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('gateways.patterns',$gateway->id)}}">
                                        <span class="text-primary">الگوی مصرف</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('electricalMeters.history',$gateway->electricalMeters->first()->id)}}">
                                        <span class="text-success">تاریخچه</span>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <form id="destroy-form-{{$gateway->id}}" method="post" action="{{route('gateways.destroy', $gateway)}}" style="display:none">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                    </form>
                                    <a href="#" onclick='destroy({{$gateway->id}});'>
                                        <i class="fa fa-fw fa-trash text-danger"></i><span class="text-danger">حذف</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="{{$gateway->id}}-children" class="collapse table-responsive"></div>
                <hr />
            @endforeach
            {{ $gateways->links() }}
        </div>
    </div>

    <script>
        $(".triangle").on("click", function () {
            if ($(this).hasClass("triangle-left")) {
                $(this).removeClass("triangle-left");
                $(this).addClass("triangle-down");
                var id = $(this).prev().val();
if (!$(`#${id}-children`).html()) {
                $.ajax(`/admin/gateways/${id}/children`, {
                    type: "get",
                    success: function (response) {
                        var data = response.data;
                        if (data.length > 0) {
                            var result = `<table class="table table-bordered" style="margin-top:10px;"><thead><tr><th>شماره پرونده</th><th>درگاه اصلی</th><th>شماره سریال کنتور</th><th>وضعیت ارتباطی</th><th>وضعیت رله 1</th>
<th>وضعیت رله 2</th><th>عملیات</th></tr></thead><tbody>`;

                            for (var i = 0; i < data.length; i++) {
                                var active = data[i].electrical_meters[0].is_active === 1 ? "<div class='label label-success'>فعال</div>" : "<div class='label label-default'>غیرفعال</div>";
                                var relay1Checked = data[i].electrical_meters[0].relay1_status === 1 ? "checked" : "";
                                var relay1 = `<span style='font-size:12px;'> روشن </span>
<label class="switch">
<input type="checkbox" ${relay1Checked} onchange="changeGatewayRelayStatus('${data[i].serial_number}', this.checked)">
<span class="slider round"></span>
</label>
<span style="font-size:12px;"> خاموش </span>`;

                                var relay2Checked = data[i].electrical_meters[0].relay2_status === 1 ? "checked" : "";
                                var relay2 = `<span style='font-size:12px;'> روشن </span>
<label class="switch">
<input type="checkbox" ${relay2Checked} onchange="changeGatewayRelay2Status('${data[i].serial_number}', this.checked)">
<span class="slider round"></span>
</label>
<span style="font-size:12px;"> خاموش </span>`;

                                var actions = `<div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                عملیات
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-left" role="menu" style="overflow-y:scroll;">
                                <li>
                                    <a href="gateways/${data[i].id}/edit">
                                        <span class="text-warning">ویرایش</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="gateways/${data[i].id}/coolingDevices">
                                        <span class="text-info">دستگاه ها</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="gateways/${data[i].id}/patterns">
                                        <span class="text-primary">الگوی مصرف</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="electricalMeters/${data[i].electrical_meters[0].id}/history">
                                        <span class="text-success">تاریخچه</span>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <form id="destroy-form-${data[[0].id]}" method="post" action="gateways/${data[i].id}" style="display:none">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                    </form>
                                    <a href="#" onclick='destroy(${data[i].id});'>
                                        <i class="fa fa-fw fa-trash text-danger"></i><span class="text-danger">حذف</span>
                                    </a>
                                </li>
                            </ul>
                        </div>`;
                                result += "<tr>" +
                                    `<td><a href="gateways/${data[i].id}/coolingDevices">` + (data[i].electrical_meters[0].parvande ? data[i].electrical_meters[0].parvande : data[i].serial_number) + "</a></td>" +
                                    "<td>" + data[i].parent_gateway.serial_number + "</td>" +
                                    "<td>" + data[i].electrical_meters[0].serial_number + "</td>" +
                                    "<td>" + active + "</td>" +
                                    "<td>" + relay1 + "</td>" +
                                    "<td>" + relay2 + "</td>" +
                                    "<td>" + actions + "</td>" +
                                    "</tr>"
                            }
                            $(`#${id}-children`).html(result + "</tbody></table>");
                        } else {
                            $(`#${id}-children`).html("<h5 style='margin-top:10px;color:gray;text-align:center;'>رکوردی وجود ندارد.</h5>");
                        }
                    }
                });
            }
            } else if ($(this).hasClass("triangle-down")) {
                $(this).removeClass("triangle-down");
                $(this).addClass("triangle-left");
            }
        });

        function changeGatewayRelayStatus(id, checked) {
            $.ajax("{{route('updateElectricityMeterRelayStatus')}}", {
                type: "post",
                data: {
                    gateway_id: id,
                    relay1_status: checked ? 1 : 0,
                    relay2_status: null
                },
                success: function (response) {
                    swal(response.message);
                }
            })
        }
        function changeGatewayRelay2Status(id, checked) {
            $.ajax("{{route('updateElectricityMeterRelay2Status')}}", {
                type: "post",
                data: {
                    gateway_id: id,
                    relay1_status: null,
                    relay2_status: checked ? 1 : 0
                },
                success: function (response) {
                    swal(response.message);
                }
            })
        }

        function destroy(itemId) {
            event.preventDefault();

            swal({
                title: "آیا این ردیف حذف شود؟",
                text: "توجه داشته باشید که عملیات حذف غیر قابل بازگشت می باشد.",
                icon: "warning",
                buttons: ["انصراف", "حذف"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    document.getElementById('destroy-form-'+itemId).submit();
                }
            });
        }
        // $(document).ready(function() {
        //     setTimeout(function() {
        //         window.location.reload();
        //     }, 20000);
        // });
    </script>
@endsection
