<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Role;
use App\Permission;
use App\user;
use App\role_user;
use DB;
use Illuminate\Support\Facades\Auth;


use App\Http\Requests\PermissionRequest;
use App\Http\Requests\RoleRequest;


use Activity;

class userroleController extends Controller
{
     public $menu = 'Role_Management';

public function __construct()
{
    $this->middleware('auth');
}

public function index()
{

}

public function user_permission()
{
     $menu = $this->menu;
      Activity::log('user at Try to create permission', Auth::id());
      if( Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin') || Auth::user()->can('create_permission'))
        return view('permission.permission',compact('menu'));
      else
        return redirect()->route('backhome')->with("message",'You Don\'t have permission');
}

public function create_permission(PermissionRequest $permission)
{
     Activity::log('user at set the permission', Auth::id());
    if (Permission::where('name', '=', $permission->input('name'))->exists()) {
      return redirect('permission')->with('status', 'This Permission All ready Exists!');
    }else
    {
        $createPermission = new Permission();
        $createPermission->name         = $permission->input('name');
        $createPermission->display_name = $permission->input('display_name'); // optional
        $createPermission->description  = $permission->input('description'); // optional
        $createPermission->save();
        return redirect('permission')->with('status', 'This Permission added successfully !');
    }
}


public function create_role()
{
     Activity::log('user Try to create Role', Auth::id());
    if( Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin') || Auth::user()->can('create_role')){
        $menu = $this->menu;
        return view('permission.roles',compact('menu'));
    }else
        return redirect()->route('backhome')->with("message",'You Don\'t have permission');
}

public function save_roles(RoleRequest $role)
{
    Activity::log('user Try to set Role', Auth::id());
    try{
        if (Role::where('name', '=', $role->input('name'))->exists()) {
             return redirect('createroles')->with('status', 'This Role All ready Exists!');
        }else
        {
            $admin = new Role();
            $admin->name         = $role->input('name');
            $admin->display_name = $role->input('display_name'); // optional
            $admin->description  = 'User is allowed to manage and edit other users'; // optional
            $admin->save();
            return redirect('createroles')->with('status', 'This Role added successfully !');
        }
    }catch(Illuminate\Database\QueryException $e)
    {
       //  return redirect('createroles')->with('status', 'This Role All ready Exists!');
    }
}

public function userpermision(){

    Activity::log('user Try to Set user Permission', Auth::id());

     if( Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin') || Auth::user()->can('set_userpermission')){
        $users = User::all();
        $roles = Role::all();
        $permissions = Permission::all();
        $menu = $this->menu;
      return view('permission.assignrole',compact('users','roles','permissions','menu'));
    }else
        return redirect()->route('backhome')->with("message",'You Don\'t have permission');
}

public function set_userpermission(Request $request){

     Activity::log('user  Set user Permission', Auth::id());
     $user_id = $request->input('user');
     $role_id = $request->input('role'); 
     $user = User::where('id', '=', $user_id)->first(); 
     $exists = DB::table('role_user')->where('user_id',$user_id)->where('role_id',$role_id)->count();
     $permission = $request->input('permission');
     if($exists ==0){
       $user->attachRole($role_id);
        $admin =  Role::where('id','=',$role_id)->first();
        $permission_id ='';
       for ($i=0; $i < (sizeof($permission)); $i++) { 
          $setpermission = Permission::where('name' ,'like',$permission[$i])->select('id')->get()->toArray();
           $permission_id .= $setpermission[0]['id'] . ",";
       }
     $permission_id =rtrim($permission_id, ",");
     $permission_id = explode(",",$permission_id);
      $admin->perms()->sync($permission_id);
     return redirect('setpermision')->with('status', '|| Done successfully !');
    }else{
        return redirect('setpermision')->with('status', '|| This  allready  some role assign  user !');
    }
}
}
