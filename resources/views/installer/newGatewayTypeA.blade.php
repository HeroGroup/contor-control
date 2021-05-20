@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">درگاه تایپ A جدید</div>
                    <div class="card-body">
                        <form method="post" action="/newGatewayTypeA">
                            @csrf
                            <div class="form-group row">
                                <label for="parent_gateway" class="col-sm-4 col-form-label">شماره سریال کنترلر اصلی</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="parent_gateway" name="parent_gateway" value="{{old('parent_gateway')}}" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="contor_serial_number" class="col-sm-4 col-form-label">شماره سریال کنتور</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="contor_serial_number" name="contor_serial_number" value="{{old('contor_serial_number')}}" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="title" class="col-sm-4 col-form-label">عنوان (اختیاری)</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}"  />
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12" style="text-align: center;">
                                    <button type="submit" class="btn btn-success" style="width:150px;">ثبت</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
