@extends('layouts.admin', ['pageTitle' => $pattern->name])
@section('content')
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
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($rows as $row)
                    <tr>
                        <td>{{$row->mode->name}}</td>
                        <td>{{$row->degree}}</td>
                        <td>{{$row->start_time}}</td>
                        <td>{{$row->end_time}}</td>
                        @component('components.links')
                            @slot('itemId'){{$row->id}}@endslot
                            @slot('routeDelete'){{route('patterns.rows.destroy',$row->id)}}@endslot
                        @endcomponent
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <div class="panel panel-info">
        <div class="panel-heading">دستگاه های در حال استفاده از این الگو</div>
        <div class="panel-body">
            <form action="{{route('coolingDevices.patterns.massStore')}}" method="post">
                @csrf
                <input type="hidden" name="pattern" value="{{$pattern->id}}" />
                @foreach($devices as $device)
                    <div>
                        <label>
                            {!! Form::checkbox('devicePatterns['.$device['id'].']', $device['id'], \App\CoolingDevicePattern::where([['cooling_device_id', $device['id']], ['pattern_id', $pattern->id]])->count()) !!}
                        </label>
                        <span class="text-info" style="font-size: 18px;">{{ $device['serial_number'] }} - {{ $device['name'] }}</span>
                    </div>
                @endforeach
                <button type="submit" class="btn btn-success">ذخیره</button>
            </form>
        </div>
    </div>
@endsection
