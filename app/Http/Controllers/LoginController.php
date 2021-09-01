<?php

namespace App\Http\Controllers;

use App\Models\Membership_card;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            //Ukoliko je OTP (is_ot_password === 1) onda napraviti redirect
            //na screen za promjenu lozinke.
            //Inače samo proslijediti na početni screen.
            $membership_card = Membership_card::where('user_id', '=', Auth::user()->id)->first();
            return response()->json(['user' =>Auth::user(), 'is_ot_password' => $membership_card->is_ot_password], 200);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.']
        ]);
    }

    public function logout()
    {
        Auth::logout();
    }

    public function otpassword_change(Request $request){
        $request->validate([
            'password' => 'string|min:8'
        ]);
        //Promjena jednokrate(is_ot_password === 1) lozinke u stalnu(is_ot_password === 0)
        $membership_card = Membership_card::where('user_id', '=', $request->user['id'])->first();
        $membership_card->password = Hash::make($request->password);
        $membership_card->is_ot_password = 0;

        if($membership_card->save()){
            return response()->json(['message' => 'Lozinka uspješno promjenjena.'], 200);
        }else{
            return response()->json(['message' => 'Dogodila se greška prilikom promjene lozinke!'], 500);
        }

    }
}
