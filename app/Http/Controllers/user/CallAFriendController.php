<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Mail\WaitingForFriend as MailWaitingForFriend;
use App\Models\Coupon;
use App\Models\WaitingForFriend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Request as ModelsRequest;
use App\Models\User;
use Carbon\Carbon;

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

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|email|unique:requests',
            'shop_office_id' => 'required|integer|exists:shop_offices,id'
        ]);

        if(ModelsRequest::create($request->all())){
            $wff = WaitingForFriend::where('token', '=', $request->token)->first();
            if($wff !== null){
                $user = User::find($wff->user_id);
                $coupon = new Coupon();
                $coupon->code = $request->name . '_' . $request->surname;
                $coupon->price = 5.00;
                $coupon->time_from = Carbon::now();
                $coupon->time_to = Carbon::now()->addDays(7);
                $coupon->active = 1;
                $coupon->user_id = $user->id;

                $coupon->save();

                $wff->delete();
            }
            return response()->json(['message' => 'Zahtjev uspješno kreiran. O preuzimanju članske iskaznice biti ćete obaviješteni putem e-mail adrese.'], 200);
        }else{
            return response()->json(['message' => 'Dogodila se greška prilikom kreiranja zahtjeva!'], 500);
        }
    }
}
