<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
    public function purchase_book(Request $request)
    {

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


        try {
            $payment = $user->charge(
                $request->input('amount'),
                $request->input('payment_method_id')
            );
            $payment = $payment->asStripePaymentIntent();
            $order = $user->orders()->create([
                'transaction_id' => $payment->charges->data[0]->id,
                'total' => $payment->charges->data[0]->amount/100 ,
                'payment_type' => 'book',
            ]);
            
            foreach(json_decode($request->input('cart'), true) as $item){
                if($item['type'] === 'book'){
                    $order->books()->attach($item['id'], ['quantity' => $item['quantity']]);
                    //Dodavanje stavke u aktivnosti
                    $activity = new Activity();
                    $activity->type = "book";
                    $activity->item_id = $item['id'];
                    $activity->message = "Kupili ste knjigu " . $item['name'] . " na datum: " . Carbon::now()->format('Y-m-d H:i:s'); 
                    $activity->quantity = $item['quantity'];
                    $activity->user_id = $user->id;
                    
                    $activity->save();
                }else if($item['type'] === 'ebook'){
                    $order->ebooks()->attach($item['id'], ['quantity' => $item['quantity']]);
                    //Dodavanje stavke u aktivnosti
                    $activity = new Activity();
                    $activity->type = "ebook";
                    $activity->item_id = $item['id'];
                    $activity->message = "Kupili ste e-knjigu " . $item['name'] . " na datum: " . Carbon::now()->format('Y-m-d H:i:s');
                    $activity->quantity = $item['quantity'];
                    $activity->user_id = $user->id;
                    
                    $activity->save();
                }else{
                    return response()->json(['message' => 'Pogrešan artikal!'], 500);
                }
            };
            //$order->load('books');

            return $order;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function purchase_membership(Request $request)
    {

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

        try {
            $date = Carbon::now()->format('Y-m-d H:i:s');
            if ($user->trial_ends_at == null) {
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

                //Dodavanje stavke u aktivnosti
                $activity = new Activity();
                $activity->type = "membership";
                $activity->item_id = $user->id;
                $activity->message = "Uplatitili ste članarinu" .  " na datum: " . Carbon::now()->format('Y-m-d H:i:s'); 
                $activity->quantity = 1;
                $activity->user_id = $user->id;
                
                $activity->save();

                return response()->json(['message' => 'Uspiješno ste se učlanili!']);
            } else if ($date < $user->trial_ends_at) {
                return response()->json(['message' => 'Članstvo već postoji!']);
            } else {
                return response()->json(['message' => 'Vaše članstvo je isteklo!']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
