<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard_info(){
        //Users
        $users_count = DB::table('users')->count();

        //Books
        $books_count = DB::table('books')->count();

        //Ebooks
        $ebooks_count = DB::table('e_books')->count();

        //Orders
        $orders_count = DB::table('orders')->count();

        //Dashboard info
        $data = collect(
            [
                ['icon' => 'mdi-account', 'count' => $users_count],
                ['icon' => 'mdi-book', 'count' => $books_count],
                ['icon' => 'mdi-file-pdf-box', 'count' => $ebooks_count],
                ['icon' => 'mdi-cart-variant', 'count' => $orders_count]
            ]
        );

        return $data;
    }
}
