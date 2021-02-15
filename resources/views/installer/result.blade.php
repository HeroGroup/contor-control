@extends('layouts.app')
@section('content')
    <div class="container">
        <div style="background-color:white;border-radius:5px;">
            <div style="text-align: left;">
                <button class="btn btn-info" style="margin:5px;" onclick="copy()">کپی شماره سریال</button>
            </div>
            <div style="display: flex;flex-direction:column;justify-content: center;align-items: center;height: 100px;">
                <label>{{$resultLabel}}</label>
                <h2 class="text-success" id="result">{{$result}}</h2>
                <label id="copied-label" class="text-info" style="visibility:hidden;">شماره سریال در حافظه کپی شد</label>
            </div>
        </div>
    </div>
    <script>
        function copy() {
            var $temp = $("<input>"), $text = $("#result").text();
            $("body").append($temp);
            $temp.val($text).select();
            document.execCommand("copy");
            $temp.remove();
            $("#copied-label").css({"visibility":"visible"});
        }
    </script>
@endsection
