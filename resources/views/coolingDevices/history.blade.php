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
            <div class="table-responsive">
                <table class="table table-bordered data-table">
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
                            <td>{{$history->mode ? $history->mode->name : ''}}</td>
                            <td>{{$history->degree}}</td>
                            <td style="direction:ltr;text-align:right;">{{jdate('Y/m/j - H:i', strtotime($history->created_at))}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{--{{ $histories->links() }}--}}
        </div>
    </div>
@endsection
