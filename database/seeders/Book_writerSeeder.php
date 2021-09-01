<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Book_writerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('book_writers')->insert([
            'book_id' => 1,
            'writer_id' => 5,
        ]);
        DB::table('book_writers')->insert([
            'book_id' => 2,
            'writer_id' => 4,
        ]);
        DB::table('book_writers')->insert([
            'book_id' => 3,
            'writer_id' => 3,
        ]);
        DB::table('book_writers')->insert([
            'book_id' => 4,
            'writer_id' => 2,
        ]);
        DB::table('book_writers')->insert([
            'book_id' => 5,
            'writer_id' => 1,
        ]);
        DB::table('book_writers')->insert([
            'book_id' => 6,
            'writer_id' => 3,
        ]);
    }
}
