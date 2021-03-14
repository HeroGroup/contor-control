@extends('layouts.admin', ['pageTitle' => 'لیست انواع اسپلیت', 'newButton' => true, 'newButtonUrl' => "/create", 'newButtonText' => 'ایجاد نوع دستگاه'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">لیست انواع دستگاه</div>
        <div class="panel-body">
            <div class="container-fluid table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>کارخانه سازنده</th>
                        <th>مدل</th>
                        <th>تعداد فاز کولر</th>
                        <th>جریان گرمادهی</th>
                        <th>جریان سرمادهی</th>
                        <th>جریان فن</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($coolingDeviceTypes as $coolingDeviceType)
                        <tr>
                            <td>{{$coolingDeviceType->manufacturer}}</td>
                            <td>{{$coolingDeviceType->model}}</td>
                            <td>{{$coolingDeviceType->number_of_phases}}</td>
                            <td>{{$coolingDeviceType->warm_current}}</td>
                            <td>{{$coolingDeviceType->cool_current}}</td>
                            <td>{{$coolingDeviceType->fan_current}}</td>
                            @component('components.links')
                                @slot('routeEdit'){{route('coolingDeviceTypes.edit',$coolingDeviceType->id)}}@endslot
                                @slot('itemId'){{$coolingDeviceType->id}}@endslot
                                @slot('routeDelete'){{route('coolingDeviceTypes.destroy',$coolingDeviceType->id)}}@endslot
                            @endcomponent
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
