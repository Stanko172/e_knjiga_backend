<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotRequest;
use App\Http\Requests\ResetRequest;
use App\Models\Membership_card;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class NewPasswordController extends Controller
{
    public function forgot(ForgotRequest $request){
        $email = $request->input('email');

        if (User::where('email', $email)->doesntExist()) {
            return response([
                'message' => 'Korisnik ne postoji!',
            ], 404);
        };

        /* $user = User::find(1);
        // Creating a token without scopes...
        $token = $user->createToken('tokenName')->accessToken; */
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token =  substr(str_shuffle(str_repeat($pool, 5)), 0, 10);

        try{
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
            ]);

            Mail::send('emails.forgot', ['token' => $token], function (Message $message) use ($email) {
                $message->to($email);
                $message->subject('Reset your password');
            });

            return response([
                'message' => 'Provjerite email',
            ]);
        }catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage(),
            ], 400);
        }
    }

    public function reset(ResetRequest $request){
        $token = $request->input('token');

        if (!$passwordResets = DB::table('password_resets')->where('token' ,$token)->first()){
            return response([
                'message' => 'Invalid token!',
            ], 400);
        };

        /** @var User $user*/
        if(!$user = User::where('email', $passwordResets->email)->first()){
            return response([
                'message' => 'Korisnik ne postoji!',
            ], 404);
        };

        $membership_card = Membership_card::where('user_id', '=', $user->id)->first();
        $membership_card->password = Hash::make($request->input('password'));
        $membership_card->is_ot_password = 0;
        $membership_card->save();

        return response([
            'message' => 'success',
        ]);

    }
}
