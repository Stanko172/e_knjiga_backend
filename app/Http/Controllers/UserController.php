<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        
    }

    public function purchase(Request $request){
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
        );
        */
        $user = User::where('email', '=', $request->input('email'))->first();

        try{
            $payment = $user->charge(
                80,
                $request->input('payment_method_id')
            );

            $payment = $payment->asStripePaymentIntent();

            /*
            $order = $user->orders()->create([
                'transaction_id' => $payment->charges->data[0]->id,
                'total' => $payment->charges->data[0]->amount,
            ]);*/

            /*
            foreach(json_decode($request->input('cart'), true) as $item){
                $order->books()->attach($item['id'], ['quantity' => $item['quantity']]);
            }
            */

            //$order->load('books');
            return response()->json(['message' => 'sve ok']);
        } catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
