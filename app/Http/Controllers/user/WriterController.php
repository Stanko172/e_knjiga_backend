<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Writer;
use Illuminate\Http\Request;

class WriterController extends Controller
{
    public function index(){
        return Writer::select('id', 'name', 'surname')->get();
    }
}
