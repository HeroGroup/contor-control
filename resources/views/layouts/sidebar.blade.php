<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{route('gateways.index')}}"><i class="fa fa-fw fa-list" style="transform: rotateY(180deg)"></i> لیست درگاه ها</a>
            </li>
            <li>
                <a href="{{route('gateways.patterns.create')}}"><i class="fa fa-fw fa-list-alt"></i> الگوهای درگاه ها</a>
            </li>
            {{--<li>--}}
                {{--<a href="{{route('electricalMeterTypes.index')}}"><i class="fa fa-laptop fa-fw"></i> سازندگان دستگاه</a>--}}
            {{--</li>--}}
            <li>
                <a href="{{route('coolingDevices.index', 0)}}"><i class="fa fa-fw fa-list" style="transform: rotateY(180deg)"></i> دستگاه ها (Cooling Devices)</a>
            </li>
            <li>
                <a href="{{route('coolingDevices.patterns.new')}}"><i class="fa fa-fw fa-list-alt"></i> الگو های دستگاه های سرمایشی</a>
            </li>
            <li>
                <a href="{{route('users.index')}}"><i class="fa fa-users fa-fw"></i>کاربران</a>
            </li>
        </ul>
    </div>
</div>
