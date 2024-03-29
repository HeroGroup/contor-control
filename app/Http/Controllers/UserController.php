<?php

namespace App\Http\Controllers;

use App\Gateway;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/admin/users');
    }

    public function edit(User $user)
    {
        $roles = Role::pluck('slug', 'id');
        $gateways = Gateway::whereNull('gateway_id')->get();
        return view('users.edit', compact('user', 'roles', 'gateways'));
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return redirect('/admin/users');
    }

    public function destroy(User $user)
    {
        return redirect('/admin/users')->with('message', 'در حال حاضر امکان حذف وجود ندارد.')->with('type', 'danger');
    }

    public function resetPassword(User $user)
    {
        try {
            $user->update(['password' => Hash::make($user->mobile)]);

            return $this->success('رمز عبور با موفقیت به شماره موبایل کاربر تغییر یافت.');
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    public function changePassword($userId)
    {
        if ($userId == auth()->id() || auth()->user()->hasRole('admin')) {
            $user = User::find($userId);
            return view('users.changePassword', compact('user'));
        } else {
            return abort(404);
        }
    }

    public function updatePassword(Request $request)
    {
        if (Hash::check($request->old_password, auth()->user()->password)) {
            if ($request->password == $request->password_confirmation) {
                auth()->user()->update(['password' => Hash::make($request->password)]);

                return redirect(route('users.changePassword', auth()->id()))->with('message', 'رمز عبور با موفقیت تغییر یافت.')->with('type', 'success');
            } else {
                return redirect(route('users.changePassword', auth()->id()))->with('message', 'رمز عبور جدید با تکرار آن همخوانی ندارد.')->with('type', 'danger');
            }
        } else {
            return redirect(route('users.changePassword', auth()->id()))->with('message', 'رمز عبور فعلی نادرست است.')->with('type', 'danger');
        }
    }

    public function assignUserGateway(Request $request)
    {
        try {
            DB::table('user_gateways')->insert([
                'user_id' => $request->user_id,
                'gateway_id' => $request->gateway_id,
            ]);
            return $this->success('success');
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    public function revokeUserGateway(Request $request)
    {
        try {
            DB::table('user_gateways')->where('user_id',$request->user_id)->where('gateway_id',$request->gateway_id)->delete();
            return $this->success('success');
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }
}
