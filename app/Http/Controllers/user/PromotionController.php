<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Promotion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index(){
        return Promotion::orderByDesc('purchases')->get();
    }

    public function show($id){
        return Promotion::find($id);
    }

    public function purchase_promotion(Request $request)
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
                'total' => $payment->charges->data[0]->amount / 100,
                'payment_type' => 'promotion',
            ]);

            $item = $request->item;

            $order->promotions()->attach($item['id'], ['quantity' => 1]);

            $user->trial_ends_at = now()->addDays(365);
            $user->address = $request->address;
            $user->city = $request->city;
            $user->state = $request->state;
            $user->postal_code = $request->postal_code;
            $user->save();

            //Dodavanje stavke u aktivnosti
            $activity = new Activity();
            $activity->type = "promotion";
            $activity->item_id = $user->id;
            $activity->message = "Kupili ste promociju" .  " na datum: " . Carbon::now()->format('Y-m-d H:i:s'); 
            $activity->quantity = 1;
            $activity->user_id = $user->id;
            
            $activity->save();

            return response()->json(['message' => 'Uspješno ste kupili promociju!']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
