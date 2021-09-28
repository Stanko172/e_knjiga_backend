<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    public function index(){
        $user = Auth::user();

        $favorites = Favorite::where('user_id', '=', $user->id)->with('writer')->get();

        $favorites->transform(function ($favorite){
            return collect([
                'writer' => $favorite->writer,
            ]);
        });
        return $favorites->pluck('writer');
    }

    public function save(Request $request){
        $writers = array_map(function($writer){
            return $writer['id'];
        }, $request->writers);

        $user = Auth::user();
        if($user->favorites()->sync($writers)){
            return response()->json(['message' => 'Uspješno ažurirani omiljeni pisci'], 200);
        }else{
            return response()->json(['message' => 'Greška prilikom ažuriranja omiljenih pisaca!'], 500);
        }
    }
}
