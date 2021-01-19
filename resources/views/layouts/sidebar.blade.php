<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{route('gateways.index')}}">
                    {{--<i class="fa fa-fw fa-list" style="transform: rotateY(180deg)"></i>--}}
                    کنترلر کنتور</a>
            </li>
            <li>
                <a href="{{route('gateways.patterns.index')}}">
                    {{--<i class="fa fa-fw fa-list-alt"></i>--}}
                    الگوی کنترلر کنتور</a>
            </li>
            <li>
                <a href="{{route('coolingDevices.index', 0)}}">
                    {{--<i class="fa fa-fw fa-list" style="transform: rotateY(180deg)"></i>--}}
                    کنترلر اسپلیت</a>
            </li>
            <li>
                <a href="{{route('patterns.index')}}">
                    {{--<i class="fa fa-fw fa-list-alt"></i>--}}
                    الگوی کنترلر اسپلیت</a>
            </li>
            <li>
                <a href="{{route('groups.index')}}">
                    {{--<i class="fa fa-fw fa-list"></i>--}}
                    گروه ها</a>
            </li>
            <li>
                <a href="{{route('reports')}}">
                    {{--<i class="fa fa-fw fa-list"></i>--}}
                    گزارشات</a>
            </li>
            @role('admin')
                <li>
                    <a href="{{route('users.index')}}">
                        {{--<i class="fa fa-users fa-fw"></i>--}}
                        کاربران</a>
                </li>
                <li>
                    <a href="{{route('permissions.index')}}">
                        نقش ها و مجوزها</a>
                </li>
            @endrole
        </ul>
    </div>
</div>
