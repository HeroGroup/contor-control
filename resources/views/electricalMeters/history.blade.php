@extends('layouts.admin', ['pageTitle' => 'تاریخچه دستگاه '.$serialNumber])
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">تاریخچه دستگاه</div>
        <div class="panel-body">
            <table class="table table-bordered data-table">
                <thead>
                <tr>
                    @foreach($labels as $label)
                        <th>{{$label}}</th>
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
                                if($i == 2) {
                                    if(strlen($items[$i]) > 8) {
                                        $temp = substr_replace(substr($items[$i],0,8), '/', 4, 0);
                                    } else {
                                        $temp = substr_replace($items[$i], '/', 4, 0);
                                    }
                                    echo "<td>".substr_replace($temp, '/', 7, 0)."</td>";
                                } else if($i == 3) {
                                    if(strlen($items[$i]) > 6) {
                                        echo "<td>".substr_replace(substr($items[$i],8,4), ':', 2, 0)."</td>";
                                    } else {
                                        echo "<td>".substr_replace($items[$i], ':', 2, 0)."</td>";
                                    }
                                } else if($i > 10) {
                                    if($items[$i] == 1) {
                                        echo "<td><div class='label label-success'>روشن</div></td>";
                                    } else {
                                        echo "<td><div class='label label-default'>خاموش</div></td>";
                                    }
                                } else {
                                    echo "<td>".$items[$i]."</td>";
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
@endsection
