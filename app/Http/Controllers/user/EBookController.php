<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\EBook;
use Illuminate\Http\Request;

class EBookController extends Controller
{
    public function index(Request $request){
        $writer_id = $request->writer_id;
        $genre_id = $request->genre_id;
        $tab = $request->tab;

        //Naknadno dodati sumu ocjena i broj ocjena, sto ce se na frontu
        //iskoristiti i za AVG ocjenu
        switch($tab){
            case '1':
                $books = EBook::with('genres','writers')
                    ->join('writer_ebooks', 'writer_ebooks.e_book_id', '=', 'e_books.id')
                    ->join('ebook_genres', 'ebook_genres.e_book_id', '=', 'e_books.id')
                    ->select('e_books.*')
                    ->when($writer_id, function ($query, $writer_id) {
                        return $query->where('writer_id', $writer_id);
                    })
                    ->when($genre_id, function ($query, $genre_id) {
                        return $query->where('genre_id', $genre_id);
                    })
                    //Potrebno dodati tablice u bazi podataka
                    //->withCount('rentals')
                    ->get();
                /*
                $books = $books->sortByDesc(function($book){
                    return $book->rentals_count;
                });


                return $books->values();
                */

                return $books->unique('id')->values();

                break;
            
            case '0':
                $books = EBook::with('genres','writers')
                ->join('writer_ebooks', 'writer_ebooks.e_book_id', '=', 'e_books.id')
                ->join('ebook_genres', 'ebook_genres.e_book_id', '=', 'e_books.id')
                ->select('e_books.*')
                ->when($writer_id, function ($query, $writer_id) {
                    return $query->where('writer_id', $writer_id);
                })
                ->when($genre_id, function ($query, $genre_id) {
                    return $query->where('genre_id', $genre_id);
                })
                //Potrebno dodati tablice u bazi podataka
                //->withCount('rentals')
                ->orderBy('id', 'desc')
                ->get();

                return $books->unique('id')->values();
        }
        
    }
}
