<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\EBook;
use App\Models\EBookRating;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

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
                $books = EBook::with('genres','writers', 'image')
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
                    ->withCount('ratings')
                    ->withSum('ratings', 'rating')
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
                $books = EBook::with('genres','writers', 'image')
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
                ->withCount('ratings')
                ->withSum('ratings', 'rating')
                ->orderBy('id', 'desc')
                ->get();

                return $books->unique('id')->values();
        }
        
    }

    public function show($id){
        $book = EBook::with('writers')
            ->withCount('ratings')
            ->withSum('ratings', 'rating')
            ->where('id', '=', $id)->first();

        $user = Auth::user();
        
        //Provjera je li korisnik kupio knjigu
        //Ako jeste može preuzeti pdf, inače ne
        if (! Gate::allows('ebook-purchased', $book)) {
            $book->is_purchased = 0;
        }else{
            $book->is_purchased = 1;  
        }

        $rating = EBookRating::where([['user_id', '=', $user->id], ['e_book_id', '=', $book->id]])->first();
        $book->is_rated = $rating === null ? 0 : 1;
        $rating !== null ? $book->rating = (float)$rating->rating : null;

        return $book;
    }

    public function download_pdf($id){
        $file = FileUpload::find($id);

        //return Storage::download("/file_uploads/" . $file->name);
        //$file = Storage::disk('public')->get('/file_uploads/' . $file->name);

        //return response()->download(storage_path("app/public/file_uploads/{$file->name}"));

        $file= storage_path("app/public/file_uploads/{$file->name}");

        $headers = [
              'Content-Type' => 'application/pdf',
           ];

        return response()->download($file, 'filename.pdf', $headers);
    }
}
