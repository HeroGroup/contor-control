@extends('layouts.admin', ['pageTitle' => 'نقش ها و مجوزها', 'newButton' => false])
@section('content')
    <style>
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            border: 1px solid #888;
            width: 50%;
            height:auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px 0 15px;
            color:#222;
        }

        .modal-body {
            padding: 20px;
            margin-bottom:20px;
            height:auto;
        }

        .close {
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">نقش ها
                    <button data-target="#new-role-modal" class="btn btn-primary btn-xs open-modal" style="float: left"><i class="fa fa-fw fa-plus"></i> نقش جدید</button>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered data-table">
                            <thead>
                            <tr>
                                <th>نقش</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{$role->name}}</td>
                                    <td>
                                        <button class="btn btn-info btn-xs open-modal" data-target="#modal-{{$role->id}}">مجوز ها</button>
                                        <button class="btn btn-success btn-xs open-modal" data-target="#edit-role-modal-{{$role->id}}">
                                            <i class="fa fa-pencil"></i> ویرایش
                                        </button>
                                        <button onclick='destroy("{{$role->id}}", "role");' class="btn btn-xs btn-danger" data-toggle="tooltip" title="حذف">
                                            <i class="fa fa-trash-o"></i> حذف
                                        </button>

                                        <div id="modal-{{$role->id}}" class="modal">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4>مجوز های {{$role->name}}</h4>
                                                    <span class="close">&times;</span>
                                                </div>
                                                <form method="post" action="{{route('roles.updateRolePermissions')}}">
                                                    @csrf
                                                    <input type="hidden" name="role_id" value="{{$role->id}}" />
                                                    <div class="modal-body">
                                                        @foreach($permissions as $key => $permission)
                                                            <div class="col-sm-4" style="color:#222;">
                                                                <label class="custom-checkbox"> {{$permission->name}}
                                                                    <input type="checkbox" name="permissions[{{$permission->id}}]" @if(\Illuminate\Support\Facades\DB::table('roles_permissions')->where('role_id',$role->id)->where('permission_id',$permission->id)->count()>0) checked @endif>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success" style="width:100px;">ثبت</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div id="edit-role-modal-{{$role->id}}" class="modal">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4>ویرایش {{$role->name}}</h4>
                                                    <span class="close">&times;</span>
                                                </div>
                                                <form method="post" action="{{route('roles.update', $role->id)}}">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="PUT">
                                                    <div class="modal-body">
                                                        <input type="text" name="name" value="{{$role->name}}" class="form-control" placeholder="عنوان نقش" />
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success" style="width:100px;">ثبت</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <form id="destroy-role-form-{{$role->id}}" method="post" action="{{route('roles.destroy',$role->id)}}" style="display:none">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                        </form>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">مجوزها
                    <button data-target="#new-permission-modal"  class="btn btn-primary btn-xs open-modal" style="float: left"><i class="fa fa-fw fa-plus"></i> مجوز جدید</button>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered data-table">
                            <thead>
                            <tr>
                                <th>مجوز</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td>{{$permission->name}}</td>
                                    <td>
                                        <button class="btn btn-success btn-xs open-modal" data-target="#edit-permission-modal-{{$permission->id}}">
                                            <i class="fa fa-pencil"></i> ویرایش
                                        </button>
                                        <button onclick='destroy("{{$permission->id}}", "permission");' class="btn btn-xs btn-danger" data-toggle="tooltip" title="حذف">
                                            <i class="fa fa-trash-o"></i> حذف
                                        </button>

                                        <div id="edit-permission-modal-{{$permission->id}}" class="modal">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4>ویرایش {{$permission->name}}</h4>
                                                    <span class="close">&times;</span>
                                                </div>
                                                <form method="post" action="{{route('permissions.update', $permission->id)}}">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="PUT">
                                                    <div class="modal-body">
                                                        <input type="text" name="name" value="{{$permission->name}}" class="form-control" placeholder="عنوان مجوز" />
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success" style="width:100px;">ثبت</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <form id="destroy-permission-form-{{$permission->id}}" method="post" action="{{route('permissions.destroy',$permission->id)}}" style="display:none">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="new-role-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4>نقش جدید</h4>
                <span class="close">&times;</span>
            </div>
            <form method="post" action="{{route('roles.store')}}">
                @csrf
                <div class="modal-body">
                    <input type="text" name="name" class="form-control" placeholder="عنوان نقش"/>
                    <br />
                    <input type="text" name="slug" class="form-control" placeholder="slug"/>
                </div>
                <div class="modal-footer" style="text-align: center;">
                    <button type="submit" class="btn btn-success" style="width:100px;">ثبت</button>
                </div>
            </form>
        </div>
    </div>

    <div id="new-permission-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4>مجوز جدید</h4>
                <span class="close">&times;</span>
            </div>
            <form method="post" action="{{route('permissions.store')}}">
                @csrf
                <div class="modal-body">
                    <input type="text" name="name" class="form-control" placeholder="عنوان مجوز"/>
                    <br />
                    <input type="text" name="slug" class="form-control" placeholder="slug"/>
                </div>
                <div class="modal-footer" style="text-align: center;">
                    <button type="submit" class="btn btn-success" style="width:100px;">ثبت</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function destroy(itemId, type) {
            event.preventDefault();

            swal({
                title: "آیا این ردیف حذف شود؟",
                text: "توجه داشته باشید که عملیات حذف غیر قابل بازگشت می باشد.",
                icon: "warning",
                buttons: ["انصراف", "حذف"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    if (type === 'role')
                        document.getElementById('destroy-role-form-'+itemId).submit();
                    else
                        document.getElementById('destroy-permission-form-'+itemId).submit();
                }
            });
        }

        $(".open-modal").on('click', function() {
            var modal = $(this).attr('data-target')
            $(modal).css({"display":"block"});
        });
        //
        // var modal = document.getElementsByClassName("modal");
        // var btn = document.getElementsByClassName("open-modal");
        var span = document.getElementsByClassName("close");
        //
        // btn.onclick = function() {
        //     console.log(this);
        //     //modal.style.display = "block";
        // };
        //

        $(".close").on("click", function() {
            $(".modal").css({"display" : "none"});
        });

        // When the user clicks anywhere outside of the modal, close it
        // window.onclick = function(event) {
        //     if (event.target === modal) {
        //         modal.style.display = "none";
        //     }
        // }
    </script>
@endsection
