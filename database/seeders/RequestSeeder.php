<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('requests')->insert([
            [
                'name' => 'Iva',
                'surname' => 'Ivic',
                'email' => 'iva@email.com',
                'shop_office_id' => 1
            ],
            [
                'name' => 'Marin',
                'surname' => 'Marinovic',
                'email' => 'marin@email.com',
                'shop_office_id' => 1
            ],
        ]);
    }
}
