<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EBook;

class EbookController extends Controller
{
    public function index(){
        $ebooks = EBook::with(['genres', 'writers'])->get();
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
        return response()->json(['message' => 'Ebook created']);
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
        $ebook = EBook::find($id);
        $ebook->update($request->all());

        return response()->json(['message' => "Ebook updated"]);
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
            return ['message' => 'Ebook deleted'];
        }
        else{
            return ['message' => 'The ebook has not been deleted'];
        }
    }
}
