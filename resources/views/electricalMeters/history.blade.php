@extends('layouts.admin', ['pageTitle' => 'تاریخچه دستگاه '.$serialNumber])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">تاریخچه دستگاه</div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    @foreach($labels as $label)
                        <th>{{$label}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @if(count($histories) > 0)
                    @foreach($histories as $history)
                        @if(count($history) > 0)
                            <tr>
                            @for($i=1; $i<=12; $i++)
                                @if($i==11 || $i==12)
                                    <td>
                                        @if($history[$i] == 1)
                                            <div class="label label-success">روشن</div>
                                        @else
                                            <div class="label label-default">خاموش</div>
                                        @endif
                                    </td>
                                @else
                                    <td>{{$history[$i]}}</td>
                                @endif
                            @endfor
                            </tr>
                        @endif
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
