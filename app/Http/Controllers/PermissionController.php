<?php
namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('permissions.index', compact('roles', 'permissions'));
    }

    public function storeRole(Request $request)
    {
        Role::create($request->all());
        return redirect(route('permissions.index'));
    }

    public function updateRole(Request $request, Role $role)
    {
        $role->update($request->all());
        return redirect(route('permissions.index'));
    }

    public function destroyRole(Request $request, Role $role)
    {
        DB::table('roles_permissions')->where('role_id',$role->id)->delete();
        $role->delete();
        return redirect(route('permissions.index'));
    }

    public function storePermission(Request $request)
    {
        Permission::create($request->all());
        return redirect(route('permissions.index'));
    }

    public function updatePermission(Request $request, Permission $permission)
    {
        $permission->update($request->all());
        return redirect(route('permissions.index'));
    }

    public function destroyPermission(Request $request, Permission $permission)
    {
        DB::table('roles_permissions')->where('permission_id',$permission->id)->delete();
        $permission->delete();
        return redirect(route('permissions.index'));
    }

    public function updateRolePermissions(Request $request)
    {
        // dd($request);
        if (count($request->permissions) > 0) {
            DB::table('roles_permissions')->where('role_id', $request->role_id)->delete();

            foreach ($request->permissions as $key=>$value) {
                DB::table('roles_permissions')->insert([
                    'role_id' => $request->role_id,
                    'permission_id' => $key
                ]);
            }
        }

        return redirect(route('permissions.index'));
    }

    public function updateUserRoles(Request $request)
    {
        if (count($request->roles) > 0) {
            DB::table('users_roles')->where('user_id', $request->user_id)->delete();

            foreach ($request->roles as $key=>$value) {
                DB::table('users_roles')->insert([
                    'user_id' => $request->user_id,
                    'role_id' => $key
                ]);
            }
        }

        return redirect(route('users.edit', $request->user_id));
    }

    public function Permission()
    {
        $dev_permission = Permission::where('slug','create-tasks')->first();
        $manager_permission = Permission::where('slug', 'edit-users')->first();

        //RoleTableSeeder.php
        $dev_role = new Role();
        $dev_role->slug = 'developer';
        $dev_role->name = 'Front-end Developer';
        $dev_role->save();
        $dev_role->permissions()->attach($dev_permission);

        $manager_role = new Role();
        $manager_role->slug = 'manager';
        $manager_role->name = 'Assistant Manager';
        $manager_role->save();
        $manager_role->permissions()->attach($manager_permission);

        $dev_role = Role::where('slug','developer')->first();
        $manager_role = Role::where('slug', 'manager')->first();

        $createTasks = new Permission();
        $createTasks->slug = 'create-tasks';
        $createTasks->name = 'Create Tasks';
        $createTasks->save();
        $createTasks->roles()->attach($dev_role);

        $editUsers = new Permission();
        $editUsers->slug = 'edit-users';
        $editUsers->name = 'Edit Users';
        $editUsers->save();
        $editUsers->roles()->attach($manager_role);

        $dev_role = Role::where('slug','developer')->first();
        $manager_role = Role::where('slug', 'manager')->first();
        $dev_perm = Permission::where('slug','create-tasks')->first();
        $manager_perm = Permission::where('slug','edit-users')->first();

        $developer = new User();
        $developer->name = 'Mahedi Hasan';
        $developer->email = 'mahedi@gmail.com';
        $developer->mobile = '09123456789';
        $developer->password = bcrypt('secrettt');
        $developer->save();
        $developer->roles()->attach($dev_role);
        $developer->permissions()->attach($dev_perm);

        $manager = new User();
        $manager->name = 'Hafizul Islam';
        $manager->email = 'hafiz@gmail.com';
        $manager->mobile = '09987654321';
        $manager->password = bcrypt('secrettt');
        $manager->save();
        $manager->roles()->attach($manager_role);
        $manager->permissions()->attach($manager_perm);


        return redirect()->back();
    }
}
