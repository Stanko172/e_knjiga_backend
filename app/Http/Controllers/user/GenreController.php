<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index(){
        return Genre::select('id', 'name')->get();
    }
}
