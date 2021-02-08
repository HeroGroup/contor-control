@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">ویرایش مشخصات فردی</div>
                    <div class="card-body">
                        <form method="post" action="#">
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label">نام</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="name" name="name" value="{{auth()->user()->name}}" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mobile" class="col-sm-4 col-form-label">عنوان (اختیاری)</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{auth()->user()->mobile}}"  />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-sm-4 col-form-label">رمز عبور جدید</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" id="password" name="password" value=""  />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password_confirmation" class="col-sm-4 col-form-label">تکرار رمز عبور جدید</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value=""  />
                                </div>
                            </div>
                            <hr />
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
