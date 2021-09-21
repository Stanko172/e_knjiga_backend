<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
    public function purchase_book(Request $request){
        /*
        $user = User::firstOrCreate(
            [
            'email' => $request->input('email')
            ],
            [
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'zip_code' => $request->input('zip_code')
            ]
        );*/
    
        $user = User::where('email', '=', $request->input('email'))->first();

        try{
            $payment = $user->charge(
                $request->input('amount'),
                $request->input('payment_method_id')
            );
            $payment = $payment->asStripePaymentIntent();
            $order = $user->orders()->create([
                'transaction_id' => $payment->charges->data[0]->id,
                'total' => $payment->charges->data[0]->amount,
                'payment_type' => 'book',
            ]);
            return response()->json(["message" => "Uspiješno ste platitli knjigu."]);
        } catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function purchase_membership(Request $request){
        
        $user = User::firstOrCreate(
            [
            'email' => $request->input('email')
            ],
            [
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'zip_code' => $request->input('zip_code')
            ]
        );
    
        try{
            $date = Carbon::now()->format('Y-m-d H:i:s');
            if($user->trial_ends_at == null ){
                $payment = $user->charge(
                    1000, //amout = 1000
                    $request->input('payment_method_id')
                );
    
                $payment = $payment->asStripePaymentIntent();
    
                $order = $user->orders()->create([
                    'transaction_id' => $payment->charges->data[0]->id,
                    'total' => $payment->charges->data[0]->amount / 100,
                    'payment_type' => 'membership_card',
                ]); 

                $user->trial_ends_at = now()->addDays(365);
                $user->address = $request->address;
                $user->city = $request->city;
                $user->state = $request->state;
                $user->postal_code = $request->postal_code;
                $user->save();
                return response()->json(['message' => 'Uspiješno ste se učlanili!']);
        }
            else if($date < $user->trial_ends_at){
                return response()->json(['message' => 'Članstvo već postoji!']);
            }
            else {
                return response()->json(['message' => 'Vaše članstvo je isteklo!']);
            }
            
        } catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
        
    }
    
}
