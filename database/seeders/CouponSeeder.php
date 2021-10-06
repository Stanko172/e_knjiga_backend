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
            'code' => 'code1',
            'price' => 10.00,
            'time_from' => Carbon::now()->format('Y-m-d H:i:s'),
            'time_to' => Carbon::now()->addDays(10),
            'active' => true,
        ]);
        DB::table('coupons')->insert([
            'user_id' => 1,
            'code' => 'code2',
            'price' => 5.00,
            'time_from' => Carbon::now()->format('Y-m-d H:i:s'),
            'time_to' => Carbon::now()->addDays(11),
            'active' => true,
        ]);
        DB::table('coupons')->insert([
            'user_id' => 1,
            'code' => 'code3',
            'price' => 8.00,
            'time_from' => Carbon::now()->format('Y-m-d H:i:s'),
            'time_to' => Carbon::now()->subDays(5),
            'active' => true,
        ]);
    }
}
