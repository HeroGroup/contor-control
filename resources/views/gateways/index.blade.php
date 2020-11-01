@extends('layouts.admin', ['pageTitle' => 'درگاه ها', 'newButton' => true, 'newButtonUrl' => 'gateways/create', 'newButtonText' => 'ایجاد درگاه'])
@section('content')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 28px;
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
            height: 20px;
            width: 20px;
            left: 8px;
            bottom: 4px;
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
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }
        .slider.round {
            border-radius: 34px;
        }
        .slider.round:before {
            border-radius: 50%;
        }
    </style>
    <div class="panel panel-default">
        <div class="panel-heading">درگاه ها</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>شماره سریال</th>
                        <th>درگاه اصلی</th>
                        <th>بازه زمانی ارسال اطلاعات (ثانیه)</th>
                        <th>وضعیت رله 1</th>
                        <th>وضعیت رله 2</th>
                        <th>تاریخ ایجاد</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($gateways as $gateway)
                        <tr>
                            <td><a href="{{route('gateways.devices',$gateway->id)}}">{{$gateway->serial_number}}</a></td>
                            <td>{{$gateway->parentGateway ? $gateway->parentGateway->serial_number : 'ندارد'}}</td>
                            <td>{{$gateway->send_data_duration_seconds}}</td>
                            <td>
                                <span> روشن </span>
                                <label class="switch">
                                    <input type="checkbox" @if($gateway->electricalMeters->first()->relay1_status == 1) checked @endif onchange="changeGatewayRelayStatus('{{$gateway->serial_number}}', this.checked)">
                                    <span class="slider round"></span>
                                </label>
                                <span> خاموش </span>
                            </td>
                            <td>
                                <span> روشن </span>
                                <label class="switch">
                                    <input type="checkbox" @if($gateway->electricalMeters->first()->relay2_status == 1) checked @endif onchange="changeGatewayRelay2Status('{{$gateway->serial_number}}', this.checked)">
                                    <span class="slider round"></span>
                                </label>
                                <span> خاموش </span>
                            </td>
                            <td>{{jdate('H:i - Y/m/j', strtotime($gateway->created_at))}}</td>
                            {{--@component('components.links')--}}
                                {{--@slot('routeEdit'){{route('gateways.edit',$gateway->id)}}@endslot--}}
                                {{--@slot('routeDevices'){{route('gateways.devices',$gateway->id)}}@endslot--}}
                                {{--@slot('routePatterns'){{route('gateways.patterns',$gateway->id)}}@endslot--}}
                                {{--@slot('routeHistory'){{route('electricalMeters.history',$gateway->electricalMeters->first()->id)}}@endslot--}}
                                {{--@slot('itemId'){{$gateway->id}}@endslot--}}
                                {{--@slot('routeDelete'){{route('gateways.destroy',$gateway->id)}}@endslot--}}
                            {{--@endcomponent--}}
                            <td><div class="btn-group">
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
                                        <a href="#">
                                            <i class="fa fa-fw fa-trash text-danger"></i><span class="text-danger">حذف</span>
                                        </a>
                                    </li>
                                </ul>
                            </div></td>
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
    </script>
@endsection
