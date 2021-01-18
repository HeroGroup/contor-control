@extends('layouts.admin', ['pageTitle' => 'مشخصات کاربر و سطوح دسترسی', 'newButton' => false])
@section('content')
    <div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading">ویرایش مشخصات کاربر</div>
        <div class="panel-body">

                {!! Form::model($user, array('route' => array('users.update', $user), 'method' => 'PUT')) !!}
                @csrf
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">نام</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-4 control-label">آدرس ایمیل</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="email" name="email" value="{{$user->email}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mobile" class="col-sm-4 control-label">شماره موبایل (نام کاربری)</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mobile" minlength="11" maxlength="11" name="mobile" value="{{$user->mobile}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8 text-left">
                            <button type="button" class="btn btn-primary" onclick="resetPassword()">بازنشانی رمزعبور</button>
                            <a class="btn btn-default" href="{{route('users.index')}}">انصراف</a>
                            <button type="submit" class="btn btn-success">ذخیره</button>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}

        </div>
    </div>
    </div>

    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">سطوح دسترسی</div>
            <div class="panel-body">
            <form method="post" action="#">
                @csrf
                <input type="hidden" name="user_id" value="{{$user->id}}">
                @foreach($roles as $key => $role)
                    <div class="col-sm-4">
                        <input type="checkbox" name="roles[{{$key}}]" @if($user->hasRole($role)) checked @endif /> {{$role}}
                    </div>
                @endforeach
                <br>
                <div class="text-left">
                    <button type="submit" class="btn btn-success">ثبت</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <script>
        function resetPassword() {
            $.ajax("{{route('users.resetPassword', $user->id)}}", {
                type: "get",
                success: function(response) {
                    swal(response.message);
                }
            })
        }

    </script>
@endsection
