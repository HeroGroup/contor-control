@extends('layouts.admin', ['pageTitle' => 'دستگاه ها', 'newButton' => true, 'newButtonUrl' => 'electricalMeters/create', 'newButtonText' => 'ایجاد دستگاه'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">دستگاه ها</div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>کد شناسایی</th>
                    <th>شماره سریال</th>
                    <th>درگاه</th>
                    <th>نوع</th>
                    <th>تاریخ ایجاد</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($electricalMeters as $electricalMeter)
                    <tr>
                        <td>{{$electricalMeter->unique_id}}</td>
                        <td>{{$electricalMeter->serial_number}}</td>
                        <td>{{$electricalMeter->gateway->serial_number}}</td>
                        <td>{{$electricalMeter->type ? $electricalMeter->type->manufacturer : ''}}{{$electricalMeter->type ? ' - ' . $electricalMeter->type->model : ''}}</td>
                        <td>{{jdate('H:i - Y/m/j', strtotime($electricalMeter->created_at))}}</td>
                        @component('components.links')
                            @slot('routeEdit'){{route('electricalMeters.edit',$electricalMeter->id)}}@endslot
                            @slot('itemId'){{$electricalMeter->id}}@endslot
                            @slot('routeDelete'){{route('electricalMeters.destroy',$electricalMeter->id)}}@endslot
                            @slot('routeHistory'){{route('electricalMeters.history',$electricalMeter->id)}}@endslot
                        @endcomponent
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
