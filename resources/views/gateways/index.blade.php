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
                        <th>وضعیت</th>
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
                                {{--<span class="label label-default">{{$gateway->electricalMeters->first()->relay1_status == 1 ? "روشن" : "خاموش"}}</span>--}}
                                <span> روشن </span>
                                <label class="switch">
                                    <input type="checkbox" @if($gateway->electricalMeters->first()->relay1_status == 1) checked @endif onchange="changeGatewayRelayStatus('{{$gateway->serial_number}}', this.checked)">
                                    <span class="slider round"></span>
                                </label>
                                <span> خاموش </span>
                                {{--<a href="#" onclick="event.preventDefault();">تغییر وضعیت</a>--}}
                            </td>
                            <td>{{jdate('H:i - Y/m/j', strtotime($gateway->created_at))}}</td>
                            @component('components.links')
                                @slot('routeEdit'){{route('gateways.edit',$gateway->id)}}@endslot
                                @slot('routeDevices'){{route('gateways.devices',$gateway->id)}}@endslot
                                @slot('routeHistory'){{route('electricalMeters.history',$gateway->electricalMeters->first()->id)}}@endslot
                                @slot('itemId'){{$gateway->id}}@endslot
                                @slot('routeDelete'){{route('gateways.destroy',$gateway->id)}}@endslot
                            @endcomponent
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function changeGatewayRelayStatus(id, checked) {
            console.log(id, checked);
            $.ajax("{{route('updateElectricityMeterRelayStatus')}}", {
                type: "post",
                data: {
                    gateway_id: id,
                    relay1_status: checked ? 1 : 0,
                    relay2_status: 0
                },
                success: function (response) {
                    swal(response.message);
                }
            })
        }
    </script>
@endsection
