@extends('layouts.admin', ['pageTitle' => 'لیست کنترلرها', 'newButton' => true, 'newButtonUrl' => "/admin/gateways/create", 'newButtonText' => 'ایجاد کنترلر'])
@section('content')
    <style>
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
            <a href="/admin/exports/gateways/{{$type}}" class="btn btn-success" style="float:left;"><i class="fa fa-fw fa-file-excel-o"></i> خروجی اکسل</a>
            <ul class="nav nav-pills">
                <li @if($type==1) class="active" @endif><a href="/admin/gateways/1">کنترلر کنتور</a></li>
                <li @if($type==2) class="active" @endif><a href="/admin/gateways/2">کنترلر بار سرمایشی</a></li>
                <li @if($type==3) class="active" @endif><a href="/admin/gateways/3">کنترلر پمپ</a></li>
            </ul>
            <hr />
            <div class="container-fluid table-responsive">
                <table class="table table-hover table-bordered data-table">
                    <thead>
                        <tr>
                            <th>پرونده</th>
                            <th>شهر</th>
                            <th>سریال کنتور</th>
                            <th>نام مشترک / شناسه</th>
                            <th>ارتباط</th>
                            <th>آخرین حضور</th>
                            <th>رله 1</th>
                            <th>رله 2</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gateways as $gateway)
                            <tr>
                                <td>
                                    <a href="{{route('gateways.devices',$gateway->id)}}">{{$gateway->electricalMeters->first()->parvande ? $gateway->electricalMeters->first()->parvande : $gateway->serial_number}}</a>
                                </td>
                                <td>
                                    {{$gateway->city_id ? $gateway->city->name : '-'}}
                                </td>
                                <td>
                                    {{$gateway->electricalMeters->first() ? $gateway->electricalMeters->first()->serial_number : ''}}
                                </td>
                                <td>
                                    {{$gateway->electricalMeters->first() ? $gateway->electricalMeters->first()->customer_name . ' ' . $gateway->electricalMeters->first()->shenase_moshtarak : ''}}
                                </td>
                                <td>
                                    @if($gateway->electricalMeters->first()->is_active)
                                        <div class="label label-success">فعال</div>
                                    @else
                                        <div class="label label-default">غیرفعال</div>
                                    @endif
                                </td>
                                <td></td>
                                <td>
                                    <span style="font-size:12px;"> وصل </span>
                                    <label class="switch">
                                        <input type="checkbox" @if($gateway->electricalMeters->first()->relay1_status == 1) checked @endif onchange="changeGatewayRelayStatus('{{$gateway->serial_number}}', this.checked)">
                                        <span class="slider round"></span>
                                    </label>
                                    <span style="font-size:12px;"> قطع </span>
                                </td>
                                <td>
                                    <span style="font-size:12px;"> وصل </span>
                                    <label class="switch">
                                        <input type="checkbox" @if($gateway->electricalMeters->first()->relay2_status == 1) checked @endif onchange="changeGatewayRelay2Status('{{$gateway->serial_number}}', this.checked)">
                                        <span class="slider round"></span>
                                    </label>
                                    <span style="font-size:12px;"> قطع </span>
                                </td>
                                <td>
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
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
                    document.getElementById('destroy-form-' + itemId).submit();
                }
            });
        }
    </script>
@endsection
