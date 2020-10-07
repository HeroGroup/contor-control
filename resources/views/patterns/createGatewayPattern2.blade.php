@extends('layouts.admin', ['pageTitle' => 'الگوهای قطع/وصل درگاه ها'])
@section('content')
    <style>
        .btn-save {
            width: 80px;
            height: 35px;
        }
    </style>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>درگاه</th>
                <th>حداکثر جریان</th>
                <th>کارکرد (دقیقه) در حداکثر جریان</th>
                <th>دقایق قطع</th>
            </tr>
            </thead>
            <tbody>
            @foreach($gateways as $gateway)
                <tr>
                    <td>{{$gateway->serial_number}}</td>
                    <td>
                        <input type="number" id="{{$gateway->id}}_max_current" name="{{$gateway->id}}_max_current" class="form-control" value="{{$gateway->patterns->count() > 0 ? $gateway->patterns->first()->max_current : ''}}" />
                    </td>
                    <td>
                        <input type="number" id="{{$gateway->id}}_minutes_after" name="{{$gateway->id}}_minutes_after" class="form-control" value="{{$gateway->patterns->count() > 0 ? $gateway->patterns->first()->minutes_after : ''}}" />
                    </td>
                    <td>
                        <input type="number" id="{{$gateway->id}}_off_minutes" name="{{$gateway->id}}_off_minutes" class="form-control" value="{{$gateway->patterns->count() > 0 ? $gateway->patterns->first()->off_minutes : ''}}" />
                    </td>
                    <td>
                        <button type="button" id="{{$gateway->id}}_save" class="btn btn-success btn-save" onclick="saveRow('{{$gateway->id}}','{{@csrf_token()}}')"><i class="fa fa-save"></i> ذخیره</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
