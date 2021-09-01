<?php

namespace App\Http\Controllers;

use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;

class MembershipRequestController extends Controller
{
    public function index(Request $request){
        return response()->json(["hah" => $request->name, "slafkjldsafk" => "testiranje"]);
    }

    public function create(Request $request){
        $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|email|unique:requests',
            'shop_office_id' => 'required|integer|exists:shop_offices,id'
        ]);

        if(ModelsRequest::create($request->all())){
            return response()->json(['message' => 'Zahtjev uspješno kreiran. O preuzimanju članske iskaznice biti ćete obaviješteni putem e-mail adrese.'], 200);
        }else{
            return response()->json(['message' => 'Dogodila se greška prilikom kreiranja zahtjeva!'], 500);
        }
    }
}
