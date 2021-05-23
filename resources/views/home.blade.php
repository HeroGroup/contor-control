@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">داشبورد</div>

                    <div class="card-body" style="padding:1.25rem 4rem;">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            @role('installer')
                            <a href="/newGatewayTypeB">
                                <div class="ccard">کنترلر کنتور جدید</div>
                            </a>
                            <a href="/newGatewayTypeA">
                                <div class="ccard">کنترلر اسپلیت جدید</div>
                            </a>
                            <a href="/newSplit">
                                <div class="ccard">اسپلیت جدید</div>
                            </a>
                            @endrole
                            <a href="/editProfile">
                                <div class="ccard">ویرایش پروفایل</div>
                            </a><a style="color:red;" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <div class="ccard">خروج</div>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
