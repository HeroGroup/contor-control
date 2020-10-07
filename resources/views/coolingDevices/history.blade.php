@extends('layouts.admin', ['pageTitle' => 'تاریخچه دستگاه '.$device->serial_number])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">تاریخچه دستگاه</div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>حالت کار</th>
                        <th>درجه</th>
                        <th>تاریخ و ساعت</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($histories as $history)
                    <tr>
                        <td>{{$history->mode->name}}</td>
                        <td>{{$history->degree}}</td>
                        <td>{{jdate('H:i - Y/m/j', strtotime($history->created_at))}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
