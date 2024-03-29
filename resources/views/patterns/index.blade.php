@extends('layouts.admin', ['pageTitle' => 'الگو های دستگاه های سرمایشی', 'newButton' => true, 'newButtonUrl' => 'coolingDevices/patterns/new', 'newButtonText' => 'ایجاد الگو'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">الگو های دستگاه های سرمایشی</div>
        <div class="panel-body">
            <div class="container-fluid table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>نام الگو</th>
                        <th>تاریخ ایجاد</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($patterns as $pattern)
                        <tr>
                            <td>{{$pattern->name}}</td>
                            <td>{{jdate('H:i Y/m/j', strtotime($pattern->created_at))}}</td>
                            @component('components.links')
                                @slot('routeDetails'){{route('patterns.show', $pattern)}}@endslot
                                @slot('itemId'){{$pattern->id}}@endslot
                                @slot('routeDelete'){{route('patterns.destroy',$pattern->id)}}@endslot
                            @endcomponent
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
