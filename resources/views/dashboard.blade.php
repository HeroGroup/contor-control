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
        }
    </style>
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-5">
                            <i class="fa fa-comments card-icon"></i>
                        </div>
                        <div class="col-xs-7 text-right card-text">
                            <div class="huge">26</div>
                            <div>New Comments!</div>
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
                            <i class="fa fa-tasks card-icon"></i>
                        </div>
                        <div class="col-xs-7 text-right card-text">
                            <div class="huge">12</div>
                            <div>New Tasks!</div>
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
                            <i class="fa fa-shopping-cart card-icon"></i>
                        </div>
                        <div class="col-xs-7 text-right card-text">
                            <div class="huge">124</div>
                            <div>New Orders!</div>
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
                            <i class="fa fa-support card-icon"></i>
                        </div>
                        <div class="col-xs-7 text-right card-text">
                            <div class="huge">13</div>
                            <div>Support Tickets!</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
