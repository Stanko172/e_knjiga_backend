<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Mail\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function create(Request $request){
        Mail::to('admin@email.com')->send(new ContactForm(['name' => $request->name, 'message' => $request->message, 'email' => $request->email]));
        return response()->json(['message' => 'Upit uspješno poslan'], 200);
    }
}
