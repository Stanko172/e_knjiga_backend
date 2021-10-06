<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Mail\WaitingForFriend as MailWaitingForFriend;
use App\Models\WaitingForFriend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CallAFriendController extends Controller
{
    public function create(Request $request){
        $user = Auth::user();

        $wff = new WaitingForFriend();
        $wff->user_id = $user->id;

        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!');
        $token = substr($random, 0, 8);
        $wff->token = $token;

        if($wff->save()){
            Mail::to($request->email)->send(new MailWaitingForFriend(['user' => $user, 'message' => $request->message, 'token' => $token]));
            return response()->json(['message' => 'Poziv uspješno kreiran.'], 200);
        }else{
            return response()->json(['message' => 'Greška prilikom kreiranja poziva!'], 500);
        }
    }
}
