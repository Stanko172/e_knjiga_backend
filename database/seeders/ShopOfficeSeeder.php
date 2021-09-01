<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shop_offices')->insert([
            [
                'name' => 'Poslovnica 1',
                'city' => 'Mostar',
                'address' => '88000, Zrinskog Frankopana 34',
                'owner' => 'John Doe',
                'mobile_number' => 063063063
            ],
            [
                'name' => 'Poslovnica 2',
                'city' => 'Mostar',
                'address' => '88000, Zrinskog Frankopana 34',
                'owner' => 'Jane Doe',
                'mobile_number' => 063062062
            ],
        ]);
    }
}
