<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([
            'name' => 'Don Quixote',
            'amount' => 10,
            'price' => 30.80      
        ]);
        DB::table('books')->insert([
            'name' => 'Lord of the Rings',
            'amount' => 10,
            'price' => 17.90      
        ]);
        DB::table('books')->insert([
            'name' => "Harry Potter and the Sorcerer's Stone",
            'amount' => 10,
            'price' => 27.10      
        ]);
        DB::table('books')->insert([
            'name' => "Alice's Adventures in Wonderland",
            'amount' => 10,
            'price' => 9.50      
        ]);
        DB::table('books')->insert([
            'name' => 'Pinocchio',
            'amount' => 10,
            'price' => 10.99      
        ]);
        DB::table('books')->insert([
            'name' => 'Fantastic Beats and Where to Find Them',
            'amount' => 10,
            'price' => 13.99      
        ]);
    }
}
