<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
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

    public function chart_data(){
        //BAR CHART
        $users = User::select('id', 'created_at')
        ->get()
        ->groupBy(function($date) {
            //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
            return Carbon::parse($date->created_at)->format('m'); // grouping by months
        });
        
        $usermcount = [];
        $userArr = [];
        
        foreach ($users as $key => $value) {
            $usermcount[(int)$key] = count($value);
        }

        $months = ['Siječanj', 'Veljača', 'Ožujak', 'Travanj', 'Svibanj', 'Lipanj', 'Srpanj', 'Kolovoz', 'Rujan', 'Listopad', 'Studeni', 'Prosinac'];
        
        for($i = 1; $i <= 12; $i++){
            if(!empty($usermcount[$i])){
                $userArr[] =  (object) array('month' => $months[$i - 1], 'num' => $usermcount[$i]);    
            }else{
                $userArr[] = (object) array('month' => $months[$i - 1], 'num' => 0);    
            }
        }
        //Niz objekata
        //$users_chart_data = $userArr;

        //Niz vrijednosti
        $users_chart_data = array_map(function($item){
            return $item->num;
        }, $userArr);

        //PIE CHART
        
        //Book purchases
        $book_purchases_count = DB::table('order_books')->count();

        //Ebook purchases
        $ebook_purchases_count = DB::table('order_ebooks')->count();

        //Book rentals
        $rentals = DB::table('rentals')->count();

        $pie_chart_data = collect(
            [
                $book_purchases_count,
                $ebook_purchases_count,
                $rentals
            ]
        );


        return response()->json(['bar_chart' => $users_chart_data, 'pie_chart' => $pie_chart_data]);
    }
}
