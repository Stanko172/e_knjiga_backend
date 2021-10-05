<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index(){
        $promotion = Promotion::orderByDesc('id')->get();
        return $promotion;
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'date' => ['required']
        ]);

        $promotion = new Promotion([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'date' => $request->input('date'),
            'purchases' => 0,
        ]);
        $promotion->save();
        return response()->json(['message' => 'Promocija kreirana.']);
    }

    public function update(Request $request, $id)
    {
        $promotion = Promotion::find($id);
        $promotion->update($request->all());

        return response()->json(['message' => "Promocija ažurirana."]);
    }

    public function destroy($id)
    {   
        $promotion = Promotion::find($id);
        $result = $promotion->delete();
        if($result){
            return ['message' => 'Promocija uspješno izbrisana.'];
        }
        else{
            return ['message' => 'Greška prilikom brisanja promocije!'];
        }
    }
}
