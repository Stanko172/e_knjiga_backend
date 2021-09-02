<?php

namespace App\Http\Controllers;

use App\Mail\MembershipRequestInfo;
use App\Models\Membership_card;
use App\Models\Request as ModelsRequest;
use App\Models\Shop_office;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class MembershipRequestController extends Controller
{
    public function index(){
        return ModelsRequest::with('shop_office')->get();
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
