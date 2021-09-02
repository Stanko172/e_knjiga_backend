<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Ebook_writerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('writer_ebooks')->insert([
            'e_book_id' => 1,
            'writer_id' => 5,
        ]);
        DB::table('writer_ebooks')->insert([
            'e_book_id' => 2,
            'writer_id' => 4,
        ]);
        DB::table('writer_ebooks')->insert([
            'e_book_id' => 3,
            'writer_id' => 3,
        ]);
        DB::table('writer_ebooks')->insert([
            'e_book_id' => 4,
            'writer_id' => 2,
        ]);
        DB::table('writer_ebooks')->insert([
            'e_book_id' => 5,
            'writer_id' => 1,
        ]);
        DB::table('writer_ebooks')->insert([
            'e_book_id' => 6,
            'writer_id' => 3,
        ]);
    }
}
