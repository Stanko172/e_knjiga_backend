<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Ebook_genreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ebook_genres')->insert([
            'e_book_id' => 5,
            'genre_id' => 1,
        ]);
        DB::table('ebook_genres')->insert([
            'e_book_id' => 4,
            'genre_id' => 1,
        ]);
        DB::table('ebook_genres')->insert([
            'e_book_id' => 4,
            'genre_id' => 2,
        ]);
        DB::table('ebook_genres')->insert([
            'e_book_id' => 3,
            'genre_id' => 1,
        ]);
        DB::table('ebook_genres')->insert([
            'e_book_id' => 3,
            'genre_id' => 3,
        ]);
        DB::table('ebook_genres')->insert([
            'e_book_id' => 2,
            'genre_id' => 1,
        ]);
        DB::table('ebook_genres')->insert([
            'e_book_id' => 2,
            'genre_id' => 4,
        ]);
        DB::table('ebook_genres')->insert([
            'e_book_id' => 1,
            'genre_id' => 5,
        ]);
        DB::table('ebook_genres')->insert([
            'e_book_id' => 6,
            'genre_id' => 1,
        ]);
        DB::table('ebook_genres')->insert([
            'e_book_id' => 6,
            'genre_id' => 2,
        ]);
    }
}
