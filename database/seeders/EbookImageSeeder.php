<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EbookImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 6; $i++){
            DB::table('ebook_images')->insert([
                'name' => $i . 'book_image.png',
                'path' => '/storage/ebook_uploads/' . $i . 'book_image.png',
                'e_book_id' => $i,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')        
            ]);
        }
    }
}
