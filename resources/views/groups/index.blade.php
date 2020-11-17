@extends('layouts.admin', ['pageTitle' => 'گروه ها', 'newButton' => true, 'newButtonUrl' => 'groups/create', 'newButtonText' => 'ایجاد گروه'])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">گروه ها</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>نام گروه</th>
                        <th>نوع گروه</th>
                        <th>الگوی مصرف</th>
                        <th>تاریخ ایجاد</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($groups as $group)
                        <tr>
                            <td>{{$group->name}}</td>
                            <td>{{config('enums.group_type.'.$group->group_type)}}</td>
                            <td>
                                @if($group->group_type == 1)
                                    <a href="{{route('groups.gatewayPattern',$group->id)}}" class="btn btn-primary btn-xs">الگوی مصرف</a>
                                @else
                                    {!! Form::select('patterns', $patterns, \App\GroupPattern::where('group_id',$group->id)->first() ? \App\GroupPattern::where('group_id',$group->id)->first()->pattern_id : '' , array('class' => 'form-control', 'placeholder' => 'انتخاب کنید...', 'id' => $group->id)) !!}
                                @endif
                            </td>
                            <td>{{jdate('H:i - Y/m/j', strtotime($group->created_at))}}</td>
                            @component('components.links')
                                @slot('routeEdit'){{route('groups.edit',$group->id)}}@endslot
                                @slot('itemId'){{$group->id}}@endslot
                                @slot('routeDelete'){{route('groups.destroy',$group->id)}}@endslot
                            @endcomponent
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $("select[name=patterns]").change(function() {
            $.ajax("{{route('groups.devicePatterns.update')}}", {
                type: "post",
                data: {
                    "_token": "{{@csrf_token()}}",
                    "group": $(this).attr('id'),
                    "pattern": $(this).val()
                },
                success: function (res) {
                    swal(res.message);
                }
            });
        });
    </script>
@endsection
