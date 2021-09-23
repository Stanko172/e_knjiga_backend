<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\User;
use Carbon\Carbon;


class CouponController extends Controller
{
    public function index(Request $request, $id){
        
        
        $coupon = Coupon::where('code', $request->code)->first();
        if($coupon != null){
            if($id == $coupon->user_id){
                if(Carbon::now() >= $coupon->time_from && Carbon::now() <= $coupon->time_to){
                    if($coupon->active == true){
                        $coupon->active = false;
                        $coupon->save();
                        return response()->json(['coupon_price' => $coupon->price]);
                    }else{
                        return response()->json(['message' => 'Kupon je iskorišten']);
                    }
                }else{
                    return response()->json(['message' => 'Kupon je istekao']);
                }
            }else{
                return response()->json(['message' => 'Trenutno nemate dozvolu za ovaj kupon']);
            }
        }
        else{
            return response()->json(['message' => 'Traženi kupon je nepoznat']);
        }
        
        return $coupon->id;
        
        //$user = User::find(1)->coupons()->where('code', $request->code)->first();
        //return $user;
    }
}
