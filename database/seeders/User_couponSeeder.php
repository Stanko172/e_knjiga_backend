<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class User_couponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_coupons')->insert([
            'user_id' => 1,
            'coupon_id' => 2,
        ]);
        DB::table('user_coupons')->insert([
            'user_id' => 1,
            'coupon_id' => 1,
        ]);
    }
}
