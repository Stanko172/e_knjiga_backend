<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Writer;

class WriterContorller extends Controller
{
    public function index(){
        $writer = Writer::with('books')->get();
        return $writer;
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
            'surname' => ['required'],
            'bday' => ['required|date_format:Y-m-d'],
            'dday' => ['required|date_format:Y-m-d'],
        ]);

        $writer = new Writer([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'bday' => $request->input('bday'),
            'dday' => $request->input('dday'),
        ]);
        $writer->save();
        return response()->json(['message' => 'Writer created']);
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
        $writer = Writer::find($id);
        $writer->update($request->all());

        return response()->json(['message' => "Writer updated"]);
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
        $writer = Writer::find($id);
        $result = $writer->delete();
        if($result){
            return ['message' => 'Writer deleted'];
        }
        else{
            return ['message' => 'The Writer has not been deleted'];
        }
    }
}
