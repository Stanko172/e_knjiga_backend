<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EBook;
use App\Models\Favorite;
use App\Models\User;
use App\Models\Waiting_for_ebook;
use App\Models\Writer;
use App\Notifications\EBookWait;
use App\Notifications\NewEbookFromFavorite;

class EbookController extends Controller
{
    public function index(){
        $ebooks = EBook::with(['genres', 'writers'])->orderByDesc('id')->get();
        return $ebooks;
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
            'price' => ['required']
        ]);

        $ebook = new Ebook([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price')
        ]);
        $ebook->save();
        
        //Dodavanje pisaca
        $writers = array_map(function($writer){
            return $writer['id'];
        }, $request->writers);

        $ebook->writers()->attach($writers);

        //Obavijesti za korisnike kojima je pisac u favorites
        foreach($writers as $writer){
            $favorites = Favorite::where('writer_id', '=', $writer)->get();
            foreach($favorites as $favorite){
                $writer = Writer::find($favorite->writer_id);
                $user = User::find($favorite->user_id);
                $user->notify(new NewEbookFromFavorite($ebook, $writer));
            }
        }

        //Dodavanje žanrova
        $genres = array_map(function($genre){
            return $genre['id'];
        }, $request->genres);

        $ebook->genres()->attach($genres);

        return response()->json(['message' => 'E-knjiga kreirana']);
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
        $book = EBook::find($id);

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
        $book->price = $request->price;
        $book->description = $request->description;

        if($book->save()){
            return response()->json(['message' => "E-knjiga spremljena!"]);
        }else{
            return response()->json(['message' => "Greška prilikom spremanja e-knjige!"]);
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
        $ebook = Ebook::find($id);
        $result = $ebook->delete();
        if($result){
            return ['message' => 'E-knjiga izbrisana!'];
        }
        else{
            return ['message' => 'Greška prilikom brisanja e-knjige!'];
        }
    }
}
