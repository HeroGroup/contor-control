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
                        <th>عنوان</th>
                        <th>درگاه</th>
                        <th>الگوی در حال پیروی</th>
                        <th>آخرین حالت کار</th>
                        <th>درجه</th>
                        {{--<th>تاریخ ایجاد</th>--}}
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($coolingDevices as $coolingDevice)
                        <tr>
                            <td>{{$coolingDevice->serial_number}}</td>
                            <td>{{$coolingDevice->name}}</td>
                            <td>{{$coolingDevice->gateway->serial_number}}</td>
                            <td>
                                {!! Form::select('patterns', $patterns, \App\CoolingDevicePattern::where('cooling_device_id', $coolingDevice->id)->first() ? \App\CoolingDevicePattern::where('cooling_device_id', $coolingDevice->id)->first()->pattern_id : '', array('class' => 'form-control', 'placeholder' => 'انتخاب کنید...', 'id' => $coolingDevice->id)) !!}
                            </td>
                            <td>
                                @if($coolingDevice->mode)
                                    @switch($coolingDevice->mode)
                                        @case(1)
                                        <div class="label label-success"><span style="color:black;">{{$coolingDevice->modeName->name}}</span></div>
                                        @break
                                        @case(3)
                                        <div class="label label-primary"><span style="color:black;">{{$coolingDevice->modeName->name}}</span></div>
                                        @break
                                        @case(4)
                                        <div class="label label-danger"><span style="color:black;">{{$coolingDevice->modeName->name}}</span></div>
                                        @break
                                        @case(5)
                                        <div class="label label-warning"><span style="color:black;">{{$coolingDevice->modeName->name}}</span></div>
                                        @break
                                    @endswitch
                                @endif
                            </td>
                            <td>{{$coolingDevice->degree}}</td>
                            {{--<td>{{jdate('H:i - Y/m/j', strtotime($coolingDevice->created_at))}}</td>--}}
                            {{--@component('components.links')--}}
                                {{--@slot('routeChangeStatus'){{route('coolingDevices.changeStatus',$coolingDevice->id)}}@endslot--}}
                                {{--@slot('routeEdit'){{route('coolingDevices.edit',$coolingDevice->id)}}@endslot--}}
                                {{--@slot('itemId'){{$coolingDevice->id}}@endslot--}}
                                {{--@slot('routeDelete'){{route('coolingDevices.destroy',$coolingDevice->id)}}@endslot--}}
                                {{--@slot('routeHistory'){{route('coolingDevices.history',$coolingDevice->id)}}@endslot--}}
                                {{--@slot('routePatterns'){{route('coolingDevices.patterns',$coolingDevice->id)}}@endslot--}}
                            {{--@endcomponent--}}
                            <td>
                                <div class="btn-group">
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
                                            <span class="text-primary">الگوی مصرف</span>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <form id="destroy-form-{{$coolingDevice->id}}" method="post" action="{{route('coolingDevices.destroy', $coolingDevice)}}" style="display:none">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                        </form>
                                        <a href="#" onclick='destroy({{$coolingDevice->id}});'>
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
        $(document).ready(function() {
            setTimeout(function() {
                window.location.reload();
            }, 20000);
        });

        $("select[name=patterns]").change(function() {
            $.ajax("{{route('coolingDevices.patterns.store')}}", {
                type: "post",
                data: {
                    "_token": "{{@csrf_token()}}",
                    "device": $(this).attr('id'),
                    "pattern": $(this).val()
                },
                success: function (res) {
                    swal(res.message);
                }
            });
        });

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
    </script>
@endsection
