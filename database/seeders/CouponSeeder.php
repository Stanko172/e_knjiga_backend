<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coupons')->insert([
            'user_id' => 1,
            'code' => 'probnicod',
            'price' => 10.00,
            'time_from' => Carbon::now()->format('Y-m-d H:i:s'),
            'time_to' => Carbon::now()->format('Y-m-d H:i:s'),
            'active' => true,
        ]);
        DB::table('coupons')->insert([
            'user_id' => 1,
            'code' => 'Probnicod',
            'price' => 5.00,
            'time_from' => Carbon::now()->format('Y-m-d H:i:s'),
            'time_to' => Carbon::now()->format('Y-m-d H:i:s'),
            'active' => true,
        ]);
    }
}
