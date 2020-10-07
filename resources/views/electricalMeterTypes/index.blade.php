@extends('layouts.admin', ['pageTitle' => 'انواع دستگاه', 'newButton' => true, 'newButtonUrl' => 'electricalMeterTypes/create', 'newButtonText' => 'ایجاد نوع دستگاه'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">انواع دستگاه</div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>شرکت سازنده</th>
                    <th>مدل</th>
                    <th>تاریخ ایجاد</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($electricalMeterTypes as $electricalMeterType)
                    <tr>
                        <td>{{$electricalMeterType->manufacturer}}</td>
                        <td>{{$electricalMeterType->model}}</td>
                        <td>{{jdate('H:i - Y/m/j', strtotime($electricalMeterType->created_at))}}</td>
                        @component('components.links')
                            @slot('routeEdit'){{route('electricalMeterTypes.edit',$electricalMeterType->id)}}@endslot
                            @slot('itemId'){{$electricalMeterType->id}}@endslot
                            @slot('routeDelete'){{route('electricalMeterTypes.destroy',$electricalMeterType->id)}}@endslot
                        @endcomponent
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
