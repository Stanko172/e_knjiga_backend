<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Waiting_for_book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaitingForBooksController extends Controller
{
    public function create(Request $request){
        $wfp = new Waiting_for_book();
        $wfp->user_id = Auth::user()->id;
        $wfp->book_id = $request->book_id;

        if($wfp->save()){
            return response()->json(['message' => 'Uspjeh!'], 200);
        }else{
            return response()->json(['message' => 'Dogodila se greška!'], 500);
        }
    }
}
