<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{route('dashboard')}}">
                    <i class="fa fa-home fa-fw"></i>
                    خانه</a>
            </li>
            @role('contor_operator')
            <li>
                <a href="{{route('gateways.index')}}">
                    {{--<i class="fa fa-fw fa-list" style="transform: rotateY(180deg)"></i>--}}
                    لیست کنترلرها</a>
            </li>
            @endrole
            @role('split_operator')
            <li>
                <a href="{{route('coolingDevices.index', 0)}}">
                    {{--<i class="fa fa-fw fa-list" style="transform: rotateY(180deg)"></i>--}}
                    لیست اسپلیت ها</a>
            </li>
            @endrole
            @role('admin')
            <li>
                <a href="#">الگوها<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{route('gateways.patterns.index')}}">
                            {{--<i class="fa fa-fw fa-list-alt"></i>--}}
                            الگوی کنترلر کنتور</a>
                    </li>
                    <li>
                        <a href="{{route('patterns.index')}}">
                            {{--<i class="fa fa-fw fa-list-alt"></i>--}}
                            الگوی کنترلر اسپلیت</a>
                    </li>
                    <li>
                        <a href="{{route('pumpPatterns.index')}}">
                            {{--<i class="fa fa-fw fa-list-alt"></i>--}}
                            الگوی کنترلر پمپ</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{route('groups.index')}}">
                    {{--<i class="fa fa-fw fa-list"></i>--}}
                    گروه ها</a>
            </li>
            @endrole
            <li>
                <a href="{{route('reports')}}">
                    {{--<i class="fa fa-fw fa-list"></i>--}}
                    گزارشات</a>
            </li>
            @role('split_codes')
            <li>
                <a href="{{route('coolingDeviceTypes.index')}}">لیست انواع اسپلیت</a>
            </li>
            <li>
                <a href="{{route('codes.index')}}">کدهای اسپلیت</a>
            </li>
            @endrole
            @role('admin')
            <li>
                <a href="#"><i class="fa fa-users fa-fw"></i> کاربران و سطوح دسترسی<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{route('users.index')}}">کاربران</a>
                    </li>
                    <li>
                        <a href="{{route('permissions.index')}}">نقش ها و مجوزها</a>
                    </li>
                </ul>
            </li>
            @endrole
        </ul>
    </div>
</div>
