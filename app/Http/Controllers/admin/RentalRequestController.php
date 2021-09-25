<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\RentalRequestReject;
use App\Mail\RentalRequestSuccess;
use App\Models\Book;
use App\Models\Rental;
use App\Models\RentalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RentalRequestController extends Controller
{
    public function index(){
        return RentalRequest::where('confirmed', '=', 0)->with('user', 'book')->get();
    }

    public function create(Request $request){
        $rental_request = RentalRequest::find($request->request_id);
        $rental_request->confirmed = 1;

        if($rental_request->save()){
            $book = Book::find($rental_request->book_id);
            $book->amount -= 1;
            if($book->save()){
                $rental = new Rental();
                $rental->user_id = $request->user_id;
                $rental->book_id = $request->book_id;
                $rental->picked_up = 0;
                $rental->returned = 0;

                $rental->save();

                Mail::to($request->user_email)->send(new RentalRequestSuccess());
                return response()->json(['message' => 'Zahtjev uspješno potvrđen'], 200);
            }else{
                return response()->json(['message' => 'Greška prilikom prilikom oduzimanja stanja knjiga!'], 500);  
            }
        }else{
            return response()->json(['message' => 'Greška prilikom potvrđivanja zahtjeva!'], 500);
        }
    }

    public function delete(Request $request){   
        $rental_request = RentalRequest::find($request->request_id);

        if($rental_request->delete()){
            Mail::to($request->user_email)->send(new RentalRequestReject(['message' => $request->message]));
            return response()->json(['message' => 'Zahtjev uspješno izbrisan'], 200);
        }else{
            return response()->json(['message' => 'Greška prilikom brisanja zahtjeva'], 500);
        }

    }
}
