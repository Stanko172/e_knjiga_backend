<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookImage;
use App\Models\Favorite;
use App\Models\User;
use App\Models\Waiting_for_book;
use App\Models\Writer;
use App\Notifications\BookWait;
use App\Notifications\NewBookFromFavorite;

use function GuzzleHttp\Promise\each;

class BookController extends Controller
{
    public function index(){
        $books = Book::with(['genres', 'writers', 'image'])->orderByDesc('id')->get();
        return $books;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        /*
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'amount' => ['required'],
            'price' => ['required']
        ]);
        */

        $book = new Book([
            'name' => $request->name,
            'description' => $request->description,
            'year' => $request->year,
            'amount' => $request->amount,
            'price' => $request->price
        ]);
        $book->save();

        //Dodavanje pisaca
        $writers = array_map(function($writer){
            $writer = json_decode($writer, true);
            return $writer['id'];
        }, $request->writers);

        $book->writers()->attach($writers);

        //Obavijesti za korisnike kojima je pisac u favorites
        foreach($writers as $writer){
            $favorites = Favorite::where('writer_id', '=', $writer)->get();
            foreach($favorites as $favorite){
                $writer = Writer::find($favorite->writer_id);
                $user = User::find($favorite->user_id);
                $user->notify(new NewBookFromFavorite($book, $writer));
            }
        }

        //Dodavanje žanrova
        $genres = array_map(function($genre){
            $genre = json_decode($genre, true);
            return $genre['id'];
        }, $request->genres);

        $book->genres()->attach($genres);

        //Dodavanje slike za knjigu
        $fileUpload = new BookImage();

        $file_name = time().'_'.$request->file->getClientOriginalName();
        $file_path = $request->file('file')->storeAs('book_uploads', $file_name, 'public');

        $fileUpload->name = time().'_'.$request->file->getClientOriginalName();
        $fileUpload->path = '/storage/' . $file_path;
        $fileUpload->book_id = $book->id;

        if($fileUpload->save()){
            return response()->json(['success'=>['Knjiga uspješno kreirana.']], 200);
        }else{
            return response()->json(['error' => "Greška prilikom kreiranja knjige!"], 500);
        }

        //return response()->json(['message' => 'Knjiga kreirana']);
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        $writers = array_map(function($writer){
            $writer = json_decode($writer, true);
            return $writer['id'];
        }, $request->writers);

        $genres = array_map(function($genre){
            $genre = json_decode($genre, true);
            return $genre['id'];
        }, $request->genres);

        //Ažuriranje međutablica
        $book->writers()->sync($writers);
        $book->genres()->sync($genres);

        //Ažuriranje knjige
        $book->name = $request->name;

        $test_amount = false;
        if($book->amount <= 0){
            $test_amount = true;
        }
        $book->amount = $request->amount;
        $book->year = $request->year;
        $book->price = $request->price;
        $book->description = $request->description;

        if($book->save()){
            if($test_amount && $book->amount > 0){
                //Obavijesti za korisnike koji čekaju ovu knjigu
                $wfp = Waiting_for_book::where('book_id', '=', $book->id)->get();
                foreach($wfp as $item){
                    $user = User::find($item->user_id);
                    $book = Book::find($item->book_id);
                    $user->notify(new BookWait($book));

                    $item->delete();
                }
            }

            if($request->file !== null){
                //Brisanje stare slike
                $book_image = BookImage::where('book_id', '=', $book->id)->first();
                $book_image->delete();

                unlink(storage_path('app/public/book_uploads/'. $book_image->name ));

                //Dodavanje slike za knjigu
                $fileUpload = new BookImage();

                $file_name = time().'_'.$request->file->getClientOriginalName();
                $file_path = $request->file('file')->storeAs('book_uploads', $file_name, 'public');

                $fileUpload->name = time().'_'.$request->file->getClientOriginalName();
                $fileUpload->path = '/storage/' . $file_path;
                $fileUpload->book_id = $book->id;

                if($fileUpload->save()){
                    return response()->json(['success'=>['Knjiga uspješno kreirana.']], 200);
                }else{
                    return response()->json(['error' => "Greška prilikom kreiranja knjige!"], 500);
                }
            }else{
                return response()->json(['message' => "Knjiga spremljena!"]);
            }
        }else{
            return response()->json(['message' => "Greška prilikom spremanja knjige!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        #return Book::where('id', $id)->delete();
        $book = Book::find($id);

        //Brisanje stare slike
        $book_image = BookImage::where('book_id', '=', $id)->first();
        $book_image->delete();

        unlink(storage_path('app/public/book_uploads/'. $book_image->name ));

        $result = $book->delete();
        if($result){
            return ['message' => 'Knjiga izbrisana'];
        }
        else{
            return ['message' => 'Greška prilikom brisanja knjige!'];
        }
    }
}
