<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Membership_card;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserMembershipController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'ot_password' => 'required|string',
            'is_ot_password' => 'required|integer'
        ]);
        
        $user = User::where('email', "=", $request->email)->first();
        if($user === null){
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
        }

        if($user->save()){

            $membership_card = new Membership_card();
            $membership_card->user_id = $user->id;
            $membership_card->ot_password = Hash::make($request->ot_password);
            $membership_card->is_ot_password = $request->is_ot_password;

            if($membership_card->save()){
                return response()->json(['message' => 'Korisnik i članska iskaznica uspješno kreirani.'], 200);
            }else{
                return response()->json(['message' => 'Greška prilikom kreiranja članske iskaznice.'], 500);
            }
        }else{
            return response()->json(['message' => 'Greška prilikom kreiranja korisnika.'], 500);
        }
    }

    public function delete(Request $request){
        $request->validate([
            'membership_card_id' => 'required|integer|exists:membership_card,id'
        ]);

        $membership_card = Membership_card::where('id', '=', $request->membership_card_id)->first();
        $user = User::where('id', '=', $membership_card->user_id)->first();

        if($membership_card->delete()){
            if($user->delete()){
                return response()->json(['message' => 'Korisnik i članska kartica uspješno izbrisani!'], 200);
            }else{
                return response()->json(['message' => 'Članska kartica izbrisana, ali se dogodila greška kod brisanja korisnika'], 500); 
            }
        }else{
            return response()->json(['message' => 'Dogodila se greška prilikom brisanja korisnika i članske kartice']);
        }
    }
}
