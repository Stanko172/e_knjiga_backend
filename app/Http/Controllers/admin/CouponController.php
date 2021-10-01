<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(){
        $coupon = Coupon::with('users')->orderByDesc('id')->get();
        return $coupon;
    }

    public function create(Request $request)
    {
        $request->validate([
            'code' => ['required'],
            'price' => ['required'],
            'users' => ['required'],
            'time_from' => ['required'],
            'time_to' => ['required']
        ]);

        $coupon = new Coupon([
            'code' => $request->input('code'),
            'price' => $request->input('price'),
            'user_id' => $request->users['id'],
            'active' => 1,
            'time_from' =>$request->input('time_from'),
            'time_to' => $request->input('time_to'),
        ]);
        $coupon->save();
        return response()->json(['message' => 'Kupon kreiran.']);
    }

    public function update(Request $request, $id){
        $request->validate([
            'code' => ['required'],
            'price' => ['required'],
            'users' => ['required'],
            'time_from' => ['required'],
            'time_to' => ['required']
        ]);

        $coupon = Coupon::where('id', '=', $id)->first();

        $coupon->code = $request->input('code');
        $coupon->price = $request->input('price');
        $coupon->user_id = $request->users['id'];
        $coupon->time_from = $request->input('time_from');
        $coupon->time_to = $request->input('time_to');

        $coupon->save();
        return response()->json(['message' => 'Kupon kreiran.']);
    }

    public function destroy($id)
    {   
        #return Book::where('id', $id)->delete();
        $writer = Coupon::find($id);
        $result = $writer->delete();
        if($result){
            return ['message' => 'Kupon izbrisan.'];
        }
        else{
            return ['message' => 'Greška prilikom brisanja kupona!'];
        }
    }

    public function users(){
        return User::all();
    }
}
