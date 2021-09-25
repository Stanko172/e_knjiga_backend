<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\BookRating;
use Illuminate\Http\Request;

class BookRatingController extends Controller
{
    public function create(Request $request){
        $book_rating_check = BookRating::where([['user_id', '=', $request->user_id], ['book_id', '=', $request->book_id]])->first();

        $book_rating = new BookRating();
        if($book_rating_check !== null){
            $book_rating = $book_rating_check;
        }
        $book_rating->book_id = $request->book_id;
        $book_rating->user_id = $request->user_id;
        $book_rating->rating = $request->rating;
        
        if($book_rating->save()){
            return response()->json(['message' => 'Ocjena uspješno spremljena'], 200);
        }else{
            return response()->json(['message' => 'Greška prilikom spremanja ocjene!'], 500);
        }
    }
}
