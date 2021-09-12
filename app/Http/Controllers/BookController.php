<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

use function GuzzleHttp\Promise\each;

class BookController extends Controller
{
    public function index(){
        $books = Book::with(['genres', 'writers'])->orderByDesc('id')->get();
        return $books;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'amount' => ['required'],
            'price' => ['required']
        ]);

        $book = new Book([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'amount' => $request->input('amount'),
            'price' => $request->input('price')
        ]);
        $book->save();

        //Dodavanje pisaca
        $writers = array_map(function($writer){
            return $writer['id'];
        }, $request->writers);

        $book->writers()->attach($writers);

        //Dodavanje žanrova
        $genres = array_map(function($genre){
            return $genre['id'];
        }, $request->genres);

        $book->genres()->attach($genres);

        return response()->json(['message' => 'Knjiga kreirana']);
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
        $book = Book::find($id);

        $writers = array_map(function($writer){
            return $writer['id'];
        }, $request->writers);

        $genres = array_map(function($genre){
            return $genre['id'];
        }, $request->genres);

        //Ažuriranje međutablica
        $book->writers()->sync($writers);
        $book->genres()->sync($genres);

        //Ažuriranje knjige
        $book->name = $request->name;
        $book->amount = $request->amount;
        $book->price = $request->price;
        $book->description = $request->description;

        if($book->save){
            return response()->json(['message' => "Knjiga spremljena!"]);
        }else{
            return response()->json(['message' => "Greška prilikom spremnja knjige!"]);
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
        $result = $book->delete();
        if($result){
            return ['message' => 'Knjiga izbrisana'];
        }
        else{
            return ['message' => 'Greška prilikom brisanja knjige!'];
        }
    }
}
