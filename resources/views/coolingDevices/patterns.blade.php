@extends('layouts.admin', ['pageTitle' => 'الگوی مصرف دستگاه '.$device->serial_number])
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <a href="{{route('coolingDevices.patterns.new', [$gateway, $device])}}" class="btn btn-primary">ایجاد الگوی مصرف (حذف الگوهای فعلی در صورت وجود)</a>
        </div>
    </div>
    <br>
    <div class="panel panel-default">
        <div class="panel-heading">الگوی مصرف</div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>حالت کار</th>
                        <th>درجه</th>
                        <th>ساعت شروع</th>
                        <th>ساعت پایان</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($patterns as $pattern)
                    <tr>
                        <td>{{$pattern->mode->name}}</td>
                        <td>{{$pattern->degree}}</td>
                        <td>{{$pattern->start_time}}</td>
                        <td>{{$pattern->end_time}}</td>
                        @component('components.links')
                            @slot('itemId'){{$pattern->id}}@endslot
                            @slot('routeDelete'){{route('patterns.destroy',$pattern->id)}}@endslot
                        @endcomponent
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
