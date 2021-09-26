<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\EBookRating;
use Illuminate\Http\Request;

class EBookRatingController extends Controller
{
    public function create(Request $request){
        $book_rating_check = EBookRating::where([['user_id', '=', $request->user_id], ['e_book_id', '=', $request->book_id]])->first();

        $book_rating = new EBookRating();
        if($book_rating_check !== null){
            $book_rating = $book_rating_check;
        }
        $book_rating->e_book_id = $request->book_id;
        $book_rating->user_id = $request->user_id;
        $book_rating->rating = $request->rating;
        
        if($book_rating->save()){
            return response()->json(['message' => 'Ocjena uspješno spremljena'], 200);
        }else{
            return response()->json(['message' => 'Greška prilikom spremanja ocjene!'], 500);
        }
    }
}
