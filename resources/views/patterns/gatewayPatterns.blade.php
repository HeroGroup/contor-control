@extends('layouts.admin', ['pageTitle' => 'الگو های درگاه ها', 'newButton' => true, 'newButtonUrl' => 'create', 'newButtonText' => 'ایجاد الگو'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">الگو های درگاه ها</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>نام الگو</th>
                        <th>حداکثر جریان (آمپر)</th>
                        <th>حداکثر زمان (دقیقه)</th>
                        <th>دقایق قطع</th>
                        <th>تاریخ ایجاد</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($patterns as $pattern)
                        <tr>
                            <td>{{$pattern->name}}</td>
                            <td>{{$pattern->rows->first()->max_current}}</td>
                            <td>{{$pattern->rows->first()->minutes_after}}</td>
                            <td>{{$pattern->rows->first()->off_minutes}}</td>
                            <td>{{jdate('H:i Y/m/j', strtotime($pattern->created_at))}}</td>
                            @component('components.links')
                                @slot('itemId'){{$pattern->id}}@endslot
                                @slot('routeDelete'){{route('gateways.patterns.destroy',$pattern->id)}}@endslot
                            @endcomponent
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
