<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Permission_role;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(){
        return Role::with('permissions')->get();
    }

    public function create(Request $request){
        $role = new Role();
        $role->title = $request->title;

        if($role->save()){
            foreach($request->permissions as $permission){
                $permission_role = new Permission_role();
                $permission_role->role_id = $role->id;
                $permission_role->permission_id = $permission['id'];

                $permission_role->save();
            }
        }
    }

    public function edit(Request $request){
        //Provjera ima li obrisanih permisija
        foreach($request->removed_items as $item){
            $permission_role = Permission_role::where([['role_id', '=', $request->id], ['permission_id', '=', $item['id']]])->first();

            if($permission_role !== null){
                $permission_role->delete();
            }
        }

        //Provjera ima li dodanih novih permisija
        foreach($request->edited_items as $item){
            $permission_role = Permission_role::where([['role_id', '=', $request->id], ['permission_id', '=', $item['id']]])->first();

            if($permission_role === null){
                $permission_role = new Permission_role();
                $permission_role->role_id = $request->id;
                $permission_role->permission_id = $item['id'];

                $permission_role->save();
            }
        }
    }

    public function delete($id){
        $role = Role::find($id);
        if($role->delete()){
            return response()->json(['message' => 'Rola uspješno izbrisana.'], 200);
        }else{
            response()->json(['message' => 'Greška prilikom brisanja role!'], 500);
        }
    }
}
