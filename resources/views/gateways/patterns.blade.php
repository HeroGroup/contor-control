@extends('layouts.admin', ['pageTitle' => 'الگوی مصرف دستگاه '.$device->serial_number])
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <a href="{{route('gateways.patterns.create')}}" class="btn btn-primary">ایجاد الگوی قطع/وصل</a>
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
                </tr>
                </thead>
                <tbody>
                @foreach($patterns as $pattern)
                    <tr>
                        <td>{{$pattern->mode->name}}</td>
                        <td>{{$pattern->degree}}</td>
                        <td>{{$pattern->start_time}}</td>
                        <td>{{$pattern->end_time}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
