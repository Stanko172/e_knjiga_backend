<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\RentalRequest;
use Illuminate\Http\Request;

class RentalRequestsController extends Controller
{
    public function create(Request $request){
        $rental_request = new RentalRequest();
        $rental_request->user_id = $request->user_id;
        $rental_request->book_id = $request->book_id;
        $rental_request->confirmed = 0;

        if($rental_request->save()){
            return response()->json(['message' => 'Zahtjev uspješno poslan'], 200);
        }else{
            return response()->json(['message' => 'Greška prilikom stvaranja zahtjeva!'], 500);
        }
    }
}
