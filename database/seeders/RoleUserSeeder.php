<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_user')->insert([
            [
                'role_id' => DB::table('roles')->where('title', 'admin')->first()->id,
                'user_id' => DB::table('users')->where('email', 'admin@email.com')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'role_id' => DB::table('roles')->where('title', 'admin')->first()->id,
                'user_id' => DB::table('users')->where('email', 'stanko@email.com')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'role_id' => DB::table('roles')->where('title', 'admin')->first()->id,
                'user_id' => DB::table('users')->where('email', 'igor@email.com')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'role_id' => DB::table('roles')->where('title', 'admin')->first()->id,
                'user_id' => DB::table('users')->where('email', 'mihael@email.com')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'role_id' => DB::table('roles')->where('title', 'admin')->first()->id,
                'user_id' => DB::table('users')->where('email', 'ivan@email.com')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'role_id' => DB::table('roles')->where('title', 'admin')->first()->id,
                'user_id' => DB::table('users')->where('email', 'tin@email.com')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);
    }
}
