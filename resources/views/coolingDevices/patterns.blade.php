@extends('layouts.admin', ['pageTitle' => 'الگوی مصرف دستگاه '.$serial_number])
@section('content')
    {{--<div class="row">--}}
        {{--<div class="col-lg-12">--}}
            {{--<a href="{{route('coolingDevices.patterns.new', [$gateway, $device])}}" class="btn btn-primary">ایجاد الگوی مصرف (حذف الگوهای فعلی در صورت وجود)</a>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<br>--}}
    <div class="panel panel-default">
        <div class="panel-heading">{{$name}}</div>
        <div class="panel-body">
            @if(count($rows) > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>حالت کار</th>
                        <th>درجه</th>
                        <th>ساعت شروع</th>
                        <th>ساعت پایان</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($rows as $row)
                    <tr>
                        <td>{{$row->mode->name}}</td>
                        <td>{{$row->degree}}</td>
                        <td>{{$row->start_time}}</td>
                        <td>{{$row->end_time}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @else
                <div style="display: flex; justify-content: center; align-items: center;">فاقد الگوی مصرف</div>
            @endif
        </div>
    </div>
@endsection
