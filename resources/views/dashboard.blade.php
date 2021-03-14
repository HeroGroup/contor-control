@extends('layouts.admin', ['pageTitle' => 'خانه', 'icon' => 'fa-home', 'newButton' => false])
@section('content')
    <style>
        @media (min-width: 767px) {
            .panel-heading {
                height:200px;
            }
            .card-text {
                /*margin-top:50px;*/
            }
            .card-icon {
                font-size: 12em;
            }
            .online {
                font-size: 18px;
            }
        }
        @media (max-width: 767px) {
            .card-icon {
                font-size: 5em;
            }
            .huge {
                font-size: 32px;
            }
            .online {
                font-size: 18px;
            }
        }
    </style>
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row" style="cursor: pointer;" onclick="route('{{route('gateways.index', 1)}}')">
                        <div class="col-xs-5" style="text-align:center">
                            <i class="fa fa-desktop card-icon"></i>
                        </div>
                        <div class="col-xs-7 text-right card-text">
                            <h3>کنترلر کنتور</h3>
                            <h4>آنلاین: {{$activeTypeAGateways}}</h4>
                            <hr />
                            <h4>تعداد کل: {{$typeAGateways}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row" style="cursor: pointer;" onclick="route('{{route('gateways.index', 2)}}')">
                        <div class="col-xs-5" style="text-align:center">
                            <i class="fa fa-tablet card-icon"></i>
                        </div>
                        <div class="col-xs-7 text-right card-text">
                            <h3>کنترلر اسپلیت</h3>
                            <h4>آنلاین: {{$activeSplitControllers}}</h4>
                            <hr />
                            <h4>تعداد کل: {{$splitControllers}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row" style="cursor: pointer;" onclick="route('{{route('gateways.index', 3)}}')">
                        <div class="col-xs-5" style="text-align:center">
                            <i class="fa fa-tint card-icon"></i>
                        </div>
                        <div class="col-xs-7 text-right card-text">
                            <h3>کنترلر پمپ</h3>
                            <h4>آنلاین: {{$activePumpGateways}}</h4>
                            <hr />
                            <h4>تعداد کل: {{$pumpGateways}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row" style="cursor: pointer;" onclick="route('{{route('coolingDevices.index', 0)}}')">
                        <div class="col-xs-5" style="text-align:center">
                            <i class="fa fa-ther card-icon"></i>
                        </div>
                        <div class="col-xs-7 text-right card-text">
                            <h3>اسپلیت</h3>
                            <h4>آنلاین: {{$activeTotalSplits}}</h4>
                            <hr />
                            <h4>تعداد کل: {{$totalSplits}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function route(route) {
            window.location.href = route;
        }
    </script>
@endsection
