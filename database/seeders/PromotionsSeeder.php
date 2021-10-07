<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PromotionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('promotions')->insert([
            'name' => 'Promorica 1',
            'description' => "Ovo je promocija 1",
            'price' => 11.00,
            'date' => Carbon::now(),
            'purchases' => 9,
        ]);
        DB::table('promotions')->insert([
            'name' => 'Promocija 2',
            'description' => "Ovo je promocija 2",
            'price' => 7.00,
            'date' => Carbon::now()->addDays(1),
            'purchases' => 10,
        ]);
    }
}
