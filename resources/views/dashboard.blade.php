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
        }
        @media (max-width: 767px) {
            .card-icon {
                font-size: 5em;
            }
            .huge {
                 font-size: 32px;
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
                            <div class="huge">{{$typeAGateways}} کنترلر کنتور</div>
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
                            <div class="huge">{{$splitControllers}} کنترلر اسپلیت</div>
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
                            <div class="huge">{{$pumpGateways}} کنترلر پمپ</div>
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
                            <div class="huge">{{$totalSplits}} اسپلیت</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
