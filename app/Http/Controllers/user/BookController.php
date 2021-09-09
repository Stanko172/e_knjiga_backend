<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request){
        $writer_id = $request->writer_id;
        $genre_id = $request->genre_id;
        $tab = $request->tab;

        //Naknadno dodati sumu ocjena i broj ocjena, sto ce se na frontu
        //iskoristiti i za AVG ocjenu
        switch($tab){
            case '1':
                $books = Book::with('genres','writers')
                    ->join('book_writers', 'book_writers.book_id', '=', 'books.id')
                    ->join('book_genres', 'book_genres.book_id', '=', 'books.id')
                    ->select('books.*')
                    ->when($writer_id, function ($query, $writer_id) {
                        return $query->where('writer_id', $writer_id);
                    })
                    ->when($genre_id, function ($query, $genre_id) {
                        return $query->where('genre_id', $genre_id);
                    })
                    ->withCount('rentals')
                    ->withCount('ratings')
                    ->withSum('ratings', 'rating')
                    ->get();
                
                $books = $books->sortByDesc(function($book){
                    return $book->rentals_count;
                });

                return $books->unique('id')->values();

                break;
            
            case '0':
                $books = Book::with('genres','writers')
                    ->join('book_writers', 'book_writers.book_id', '=', 'books.id')
                    ->join('book_genres', 'book_genres.book_id', '=', 'books.id')
                    ->select('books.*')
                    ->when($writer_id, function ($query, $writer_id) {
                        return $query->where('writer_id', $writer_id);
                    })
                    ->when($genre_id, function ($query, $genre_id) {
                        return $query->where('genre_id', $genre_id);
                    })
                    ->withCount('rentals')
                    ->withCount('ratings')
                    ->withSum('ratings', 'rating')
                    ->orderBy('id', 'desc')
                    ->get();

                return $books->unique('id')->values();
        }
        
    }
}
