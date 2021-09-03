<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Membership_cardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('membership_card')->insert([
            [
                'user_id' => DB::table('users')->where('email', '=', 'admin@email.com')->first()->id,
                'password' => Hash::make('12345678'),
                'is_ot_password' => 0,
            ],
            [
                'user_id' => DB::table('users')->where('email', '=', 'stanko@email.com')->first()->id,
                'password' => Hash::make('12345678'),
                'is_ot_password' => 0,
            ],
            [
                'user_id' => DB::table('users')->where('email', '=', 'igor@email.com')->first()->id,
                'password' => Hash::make('12345678'),
                'is_ot_password' => 0,
            ],
            [
                'user_id' => DB::table('users')->where('email', '=', 'mihael@email.com')->first()->id,
                'password' => Hash::make('12345678'),
                'is_ot_password' => 1,
            ],
            [
                'user_id' => DB::table('users')->where('email', '=', 'ivan@email.com')->first()->id,
                'password' => Hash::make('12345678'),
                'is_ot_password' => 1,
            ],
            [
                'user_id' => DB::table('users')->where('email', '=', 'tin@email.com')->first()->id,
                'password' => Hash::make('12345678'),
                'is_ot_password' => 1,
            ],
        ]);
    }
}
