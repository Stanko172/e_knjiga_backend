<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

use function GuzzleHttp\Promise\each;

class BookController extends Controller
{
    public function index(){
        $books = Book::with(['genres', 'writers'])->get();
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
            'amount' => $request->input('amount'),
            'price' => $request->input('price')
        ]);
        $book->save();
        return response()->json(['message' => 'Book created']);
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

        return response()->json(['message' => "Book updated"]);
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
