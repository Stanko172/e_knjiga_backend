<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Membership_card;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        return User::with('roles')->get();
    }

    public function create(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;

        if($user->save()){
            foreach($request->roles as $role){
                $role_user = new RoleUser();
                $role_user->user_id = $user->id;
                $role_user->role_id = $role['id'];

                $role_user->save();
            }
        }

        $membership_card = new Membership_card();
        $membership_card->password = Hash::make($request->password);
        $membership_card->user_id = $user->id;
        $membership_card->is_ot_password = 0;

        $membership_card->save();
    }

    public function edit(Request $request){
        //Provjera ima li obrisanih permisija
        foreach($request->removed_items as $item){
            $role_user = RoleUser::where([['user_id', '=', $request->id], ['role_id', '=', $item['id']]])->first();

            if($role_user !== null){
                $role_user->delete();
            }
        }

        //Provjera ima li dodanih novih permisija
        foreach($request->edited_items as $item){
            $role_user = RoleUser::where([['user_id', '=', $request->id], ['role_id', '=', $item['id']]])->first();

            if($role_user === null){
                $role_user = new RoleUser();
                $role_user->user_id = $request->id;
                $role_user->role_id = $item['id'];

                $role_user->save();
            }
        }
    }

    public function delete($id){
        $user = User::find($id);
        if($user->delete()){
            DB::table('membership_card')->where('user_id', $id)->delete();

            return response()->json(['message' => 'Korisnik uspješno izbrisan.'], 200);
        }else{
            response()->json(['message' => 'Greška prilikom brisanja korisnika!'], 500);
        }
    }
}
