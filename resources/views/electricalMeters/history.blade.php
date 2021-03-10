@extends('layouts.admin', ['pageTitle' => 'تاریخچه کنتور '.$electricalMeter->serial_number])
@section('content')
    <style>
        .text-align-left {
            text-align: left;
        }
        .fs-16 {
            font-size:16px;
        }
    </style>
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 text-align-left">شماره پرونده: </label>
                        <p class="col-sm-4 fs-16">{{$electricalMeter->parvande}}</p>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 text-align-left">نام مشترک: </label>
                        <p class="col-sm-4 fs-16">{{$electricalMeter->customer_name}}</p>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 text-align-left">آدرس: </label>
                        <p class="col-sm-4 fs-16">{{$electricalMeter->customer_address}}</p>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 text-align-left">شناسه مشترک: </label>
                        <p class="col-sm-4 fs-16">{{$electricalMeter->shenase_moshtarak}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">تاریخچه دستگاه</div>
            <div class="panel-body">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        @foreach($labels as $label)
                            <th>{{$label->parameter_label}} @if($label->parameter_unit) ({{$label->parameter_unit}}) @endif</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @if($histories->count() > 0)
                        @foreach($histories as $history)
                            <tr>
                                <?php
                                $items = explode('&', $history->parameter_values);
                                for($i=1; $i<=12; $i++) {
                                    if($i == 2) { // date
                                        if(strlen($items[$i]) > 8) {
                                            $temp = substr_replace(substr($items[$i],0,8), '/', 4, 0);
                                        } else {
                                            $temp = substr_replace($items[$i], '/', 4, 0);
                                        }
                                        echo "<td>".substr_replace($temp, '/', 7, 0)."</td>";
                                    } else if($i == 3) { // time
                                        if(strlen($items[$i]) > 6) {
                                            echo "<td>".substr_replace(substr($items[$i],8,4), ':', 2, 0)."</td>";
                                        } else {
                                            echo "<td>".substr_replace($items[$i], ':', 2, 0)."</td>";
                                        }
                                    } else if($i > 10) { // relay status
                                        if($items[$i] == 1) {
                                            echo "<td><div class='label label-success'>وصل</div></td>";
                                        } else {
                                            echo "<td><div class='label label-default'>قطع</div></td>";
                                        }
                                    } else {
                                        echo "<td>".doubleval($items[$i])."</td>";
                                    }
                                }
                                ?>
                            </tr>
                        @endforeach
                    @else
                        <h4 style="text-align:center;">تاریخچه وجود ندارد</h4>
                    @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
