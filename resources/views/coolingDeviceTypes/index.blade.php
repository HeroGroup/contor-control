@extends('layouts.admin', ['pageTitle' => 'لیست انواع اسپلیت', 'newButton' => true, 'newButtonUrl' => "/create", 'newButtonText' => 'ایجاد نوع دستگاه'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">لیست انواع دستگاه</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>کارخانه سازنده</th>
                        <th>مدل</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($coolingDeviceTypes as $coolingDeviceType)
                        <tr>
                            <td>{{$coolingDeviceType->manufacturer}}</td>
                            <td>{{$coolingDeviceType->model}}</td>
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
