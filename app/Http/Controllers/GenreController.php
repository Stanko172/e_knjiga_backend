<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    public function index(){
        $genres = Genre::with(['books', 'ebooks'])->get();
        return $genres;
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
        ]);

        $genre = new Genre([
            'name' => $request->input('name'),
        ]);
        $genre->save();
        return response()->json(['message' => 'Genre created']);
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
        $genres = Genre::find($id);
        $genres->update($request->all());

        return response()->json(['message' => "Genre updated"]);
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
        $genre = Genre::find($id);
        $result = $genre->delete();
        if($result){
            return ['message' => 'Genre deleted'];
        }
        else{
            return ['message' => 'The Genre has not been deleted'];
        }
    }
}
