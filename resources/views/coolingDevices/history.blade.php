@extends('layouts.admin', ['pageTitle' => 'تاریخچه دستگاه '.$device->serial_number])
@section('content')
    <style>
        .pagination > ul {
            display: flex;
            justify-content: center;
        }
    </style>
    <div class="panel panel-default">
        <div class="panel-heading">تاریخچه دستگاه</div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>حالت کار</th>
                        <th>درجه</th>
                        <th>زمان تغییر</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($histories as $history)
                    <tr>
                        <td>{{$history->mode->name}}</td>
                        <td>{{$history->degree}}</td>
                        <td>{{jdate('Y/m/j - H:i', $history->created_at)}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $histories->links() }}
        </div>
    </div>
@endsection
