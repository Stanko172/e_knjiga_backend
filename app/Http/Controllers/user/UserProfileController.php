<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\ProfileImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    public function show(){
        $id = Auth::user()->id;
        $user = User::where('id', '=', $id)->with('image')->first();

        $books_purchased = DB::table('orders')->join('order_books', 'orders.id', '=', 'order_books.order_id')->where('user_id', '=', $id)->sum('order_books.quantity');
        $ebooks_purchased = DB::table('orders')->join('order_ebooks', 'orders.id', '=', 'order_ebooks.order_id')->where('user_id', '=', $id)->sum('order_ebooks.quantity');
        $rentals = DB::table('rentals')->where('user_id', '=', $id)->count();

        $user->books_purchased = (int) $books_purchased;
        $user->ebooks_purchased = (int) $ebooks_purchased;
        $user->rentals = $rentals;

        return $user;
    }

    public function image(Request $request){
        $user = Auth::user();
        
        $fileUpload = ProfileImage::where('user_id', '=', $user->id)->first();
        if($fileUpload !== null){
            //Brisanje stare slike
            $fileUpload->delete();

            unlink(storage_path('app/public/profile_uploads/'. $fileUpload->name ));
        }

        $fileUpload = new ProfileImage();

        $file_name = time().'_'.$request->file->getClientOriginalName();
        $file_path = $request->file('file')->storeAs('profile_uploads', $file_name, 'public');

        $fileUpload->name = time().'_'.$request->file->getClientOriginalName();
        $fileUpload->path = '/storage/' . $file_path;
        $fileUpload->user_id = $user->id;

        if($fileUpload->save()){
            return response()->json(['success'=>['Slika uspješno spremljena.']], 200);
        }else{
            return response()->json(['error' => "Greška prilikom spremanja slike!"], 500);
        }
    }

    public function save(Request $request){
        $user = Auth::user();
        $user = User::where('id', '=', $user->id)->first();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->address = $request->address;
        $user->postal_code = $request->postal_code;

        if($user->save()){
            return response()->json(['message' => 'Informacije uspješno spremljene.'], 200);
        }else{
            return response()->json(['message' => 'Greška prilikom spremanja informacija!'], 500);
        }
    }
}
