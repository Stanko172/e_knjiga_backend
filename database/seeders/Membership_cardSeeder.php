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
            'user_id' => 1,
            'ot_password' => '$2y$10$V4b9D/wvUuMH6MKhku./ceFu6KCadn7UzCGCHYcmSgl8H4zGfFjCa',
            'is_ot_password' => false,
        ]);
    }
}
