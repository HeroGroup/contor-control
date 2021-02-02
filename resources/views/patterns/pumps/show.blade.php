@extends('layouts.admin', ['pageTitle' => "$pattern->name"])
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">الگوی مصرف</div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>حالت کار</th>
                            <th>ساعت شروع</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows as $row)
                            <tr>
                                <td>
                                    @if($row->relay_status)
                                        <div class="label label-success">{{config('enums.relay_status.'.$row->relay_status)}}</div>
                                    @else
                                        <div class="label label-default">{{config('enums.relay_status.'.$row->relay_status)}}</div>
                                    @endif
                                </td>
                                <td>{{$row->start_time}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-info">
                <div class="panel-heading">دستگاه های در حال استفاده از این الگو</div>
                <div class="panel-body">
                    @if($pumps->count() > 0)
                        <form action="{{route('pumpsPatterns.massStore')}}" method="post">
                            @csrf
                            <input type="hidden" name="pattern" value="{{$pattern->id}}" />
                            @foreach($pumps as $pump)
                                <div>
                                    <label class="custom-checkbox"> {{ $pump['serial_number'] }}
                                        <input type="checkbox" name="pumps[{{$pump['id']}}]" value="{{$pump['id']}}" @if(\App\GatewayPattern::where([['gateway_id', $pump['id']], ['pattern_id', $pattern->id]])->count()) checked @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-success">ذخیره</button>
                        </form>
                    @else
                        <h4 style="text-align: center;color:gray">کنترلر پمپ وجود ندارد</h4>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
