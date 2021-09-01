<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Book_genre;
use App\Models\Writer;
use App\Models\Book_writer;
use App\Models\Genre;

use function GuzzleHttp\Promise\each;

class BookController extends Controller
{
    public function index(){
        $books = Book::get();
        foreach($books as $book){
            $book_id = $book->id;
            $book_genre_id = Book_genre::where('book_id', $book_id)->get('genre_id')->first();
            $book_genre_name = Genre::where('id', $book_genre_id->genre_id)->get('name')->first();
            $book->genre = $book_genre_name;

            $book_writer_id = Book_writer::where('book_id', $book_id)->get('writer_id')->first();
            $writer_name = Writer::where('id', $book_writer_id->writer_id)->get(['name'])->first()->name;
            $writer_surname = Writer::where('id', $book_writer_id->writer_id)->get(['surname'])->first()->surname;
            $book->writer_name = $writer_name;
            $book->writer_surname = $writer_surname;
            unset($book_id);
        }
        return response()->json($books);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $books = Book::find($id);
        $books->update($request->all());

        return response()->json(['message' => "Book updated", 200]);
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
        $result = $book->delete();
        if($result){
            return ['message' => 'Book deleted'];
        }
        else{
            return ['message' => 'The book has not been deleted'];
        }
    }
}
