@extends('layouts.admin', ['pageTitle' => "دستگاه ها (Cooling Devices)", 'newButton' => true, 'newButtonUrl' => "$gateway/create", 'newButtonText' => 'ایجاد دستگاه'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">دستگاه ها @if($gateway>0) <span>ی درگاه {{\App\Gateway::find($gateway)->serial_number}}</span> @endif</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>شماره سریال</th>
                        <th>درگاه</th>
                        <th>آخرین حالت کار</th>
                        <th>درجه</th>
                        <th>تاریخ ایجاد</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($coolingDevices as $coolingDevice)
                        <tr>
                            <td>{{$coolingDevice->serial_number}}</td>
                            <td>{{$coolingDevice->gateway->serial_number}}</td>
                            <td>{{$coolingDevice->mode ? $coolingDevice->modeName->name : ""}}</td>
                            <td>{{$coolingDevice->degree}}</td>
                            <td>{{jdate('H:i - Y/m/j', strtotime($coolingDevice->created_at))}}</td>
                            @component('components.links')
                                @slot('routeChangeStatus'){{route('coolingDevices.changeStatus',$coolingDevice->id)}}@endslot
                                @slot('routeEdit'){{route('coolingDevices.edit',$coolingDevice->id)}}@endslot
                                @slot('itemId'){{$coolingDevice->id}}@endslot
                                @slot('routeDelete'){{route('coolingDevices.destroy',$coolingDevice->id)}}@endslot
                                @slot('routeHistory'){{route('coolingDevices.history',$coolingDevice->id)}}@endslot
                                @slot('routePatterns'){{route('coolingDevices.patterns',$coolingDevice->id)}}@endslot
                            @endcomponent
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
