<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FileUploadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 6; $i++){
            DB::table('file_uploads')->insert([
                'name' => $i . 'test_pdf.pdf',
                'path' => '/storage/file_uploads/' . $i . 'test_pdf.pdf',
                'e_book_id' => $i,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')        
            ]);
        }
    }
}
