@extends('layouts.admin', ['pageTitle' => 'خانه', 'icon' => 'fa-home', 'newButton' => false])
@section('content')
    <style>
        @media (min-width: 767px) {
            .panel-heading {
                height:200px;
            }
            .card-text {
                margin-top:50px;
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
                    <div class="row">
                        <div class="col-xs-5">
                            <i class="fa fa-desktop card-icon"></i>
                        </div>
                        <div class="col-xs-7 text-right card-text">
                            <div class="huge">{{$typeAGateways}} / {{$activeTypeAGateways}} <span class="online"> آنلاین</span></div>
                            <h3>کنترلر کنتور</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-5">
                            <i class="fa fa-tablet card-icon"></i>
                        </div>
                        <div class="col-xs-7 text-right card-text">
                            <div class="huge">{{$splitControllers}} / {{$activeSplitControllers}} <span class="online"> آنلاین</span></div>
                            <h3>کنترلر اسپلیت</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-5">
                            <i class="fa fa-tint card-icon"></i>
                        </div>
                        <div class="col-xs-7 text-right card-text">
                            <div class="huge">{{$pumpGateways}} / {{$activePumpGateways}} <span class="online"> آنلاین</span></div>
                            <h3>کنترلر پمپ</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-5">
                            <i class="fa fa-ther card-icon"></i>
                        </div>
                        <div class="col-xs-7 text-right card-text">
                            <div class="huge">{{$totalSplits}} / {{$activeTotalSplits}} <span class="online"> آنلاین</span></div>
                             <h3>اسپلیت</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
