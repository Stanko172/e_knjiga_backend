<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalRequestConfirmedController extends Controller
{
    public function index(){
        return Rental::with('user', 'book')->get();
    }

    public function picked_up($id){
        $rental = Rental::find($id);
        $rental->picked_up = $rental->picked_up === 1 ? 0 : 1;

        if($rental->save()){
            return response()->json(['message' => 'Uspješno spremljeno'], 200);
        }else{
            return response()->json(['message' => 'Greška prilikom spremanja!'], 500);
        }
    }

    public function returned($id){
        $rental = Rental::find($id);
        $rental->returned = $rental->returned === 1 ? 0 : 1;

        if($rental->save()){
            $book = Book::find($rental->book_id);
            if($rental->returned === 1){
                $book->amount += 1;
            }else{
                $book->amount -= 1;
            }

            $book->save();
            return response()->json(['message' => 'Uspješno spremljeno'], 200);
        }else{
            return response()->json(['message' => 'Greška prilikom spremanja!'], 500);
        }
    }
}
