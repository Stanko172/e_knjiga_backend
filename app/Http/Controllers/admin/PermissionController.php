<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(){
        return Permission::all();
    }

    public function save(Request $request){
        $request->validate([
            'title' => 'required|string'
        ]);

        if(!isset($request->id)){
            if(Permission::create($request->all())){
                return response()->json(['message' => 'Permission created.'], 200);
            }else{
                return response()->json(['message' => 'Error while creating permission!'], 500);
            }
        }else{
            $request->validate([
                'id' => 'required|exists:permissions,id'
            ]);

            $permission = Permission::find($request->id);
            $permission->title = $request->title;

            if($permission->save()){
                return response()->json(['message' => 'Permission updated.'], 200);
            }else{
                return response()->json(['message' => 'Error while updating permission!'], 500);
            }
        }
    }

    public function delete($id){
        $permission = Permission::findOrFail($id);
        if($permission->delete()){
            return response()->json(['message' => 'Permission deleted.'], 200);
        }else{ 
            return response()->json(['message' => 'error while deleting permission!'], 500);
        }
    }
}
