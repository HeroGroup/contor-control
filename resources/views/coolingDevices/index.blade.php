@extends('layouts.admin', ['pageTitle' => "دستگاه ها (Cooling Devices)", 'newButton' => true, 'newButtonUrl' => "$gateway/create", 'newButtonText' => 'ایجاد دستگاه'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">دستگاه ها @if($gateway>0) <span>ی درگاه {{\App\Gateway::find($gateway)->serial_number}}</span> @endif</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>شماره سریال</th>
                        <th>درگاه</th>
                        <th>آخرین حالت کار</th>
                        <th>درجه</th>
                        <th>تاریخ ایجاد</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($coolingDevices as $coolingDevice)
                        <tr>
                            <td>{{$coolingDevice->serial_number}}</td>
                            <td>{{$coolingDevice->gateway->serial_number}}</td>
                            <td>
                                @if($coolingDevice->mode)
                                    @switch($coolingDevice->mode)
                                        @case(1)
                                        <div class="label label-default">{{$coolingDevice->modeName->name}}</div>
                                        @break
                                        @case(3)
                                        <div class="label label-success">{{$coolingDevice->modeName->name}}</div>
                                        @break
                                        @case(4)
                                        <div class="label label-primary">{{$coolingDevice->modeName->name}}</div>
                                        @break
                                        @case(5)
                                        <div class="label label-danger">{{$coolingDevice->modeName->name}}</div>
                                        @break
                                    @endswitch
                                @endif
                            </td>
                            <td>{{$coolingDevice->degree}}</td>
                            <td>{{jdate('H:i - Y/m/j', strtotime($coolingDevice->created_at))}}</td>
                            {{--@component('components.links')--}}
                                {{--@slot('routeChangeStatus'){{route('coolingDevices.changeStatus',$coolingDevice->id)}}@endslot--}}
                                {{--@slot('routeEdit'){{route('coolingDevices.edit',$coolingDevice->id)}}@endslot--}}
                                {{--@slot('itemId'){{$coolingDevice->id}}@endslot--}}
                                {{--@slot('routeDelete'){{route('coolingDevices.destroy',$coolingDevice->id)}}@endslot--}}
                                {{--@slot('routeHistory'){{route('coolingDevices.history',$coolingDevice->id)}}@endslot--}}
                                {{--@slot('routePatterns'){{route('coolingDevices.patterns',$coolingDevice->id)}}@endslot--}}
                            {{--@endcomponent--}}
                            <td><div class="btn-group">
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                    عملیات
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu pull-left" role="menu">
                                    <li>
                                        <a href="{{route('coolingDevices.changeStatus',$coolingDevice->id)}}">
                                            <span class="text-dark">تغییر وضعیت</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('coolingDevices.edit',$coolingDevice->id)}}">
                                            <span class="text-warning">ویرایش</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('coolingDevices.history',$coolingDevice->id)}}">
                                            <span class="text-success">تاریخچه</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('coolingDevices.patterns',$coolingDevice->id)}}">
                                            <span class="text-primary">الگوها</span>
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
        $(document).ready(function() {
            setTimeout(function() {
                window.location.reload();
            }, 20000);
        });
    </script>
@endsection
