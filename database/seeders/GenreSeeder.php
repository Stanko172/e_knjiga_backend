<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genres')->insert([
            'name' => 'Fantasy',
        ]);
        DB::table('genres')->insert([
            'name' => 'Sci-fi',
        ]);
        DB::table('genres')->insert([
            'name' => 'Mystery',
        ]);
        DB::table('genres')->insert([
            'name' => 'Thriller',
        ]);
        DB::table('genres')->insert([
            'name' => 'Romance',
        ]);
        DB::table('genres')->insert([
            'name' => 'Westerns',
        ]);
        DB::table('genres')->insert([
            'name' => 'Dystopian',
        ]);
        DB::table('genres')->insert([
            'name' => 'Contemporary',
        ]);
    }
}
