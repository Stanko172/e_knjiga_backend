<?php

namespace App\Http\Controllers;

use App\Models\Shop_office;
use Illuminate\Http\Request;

class ShopOfficeController extends Controller
{
    public function index(){
        return Shop_office::all();
    }
}
