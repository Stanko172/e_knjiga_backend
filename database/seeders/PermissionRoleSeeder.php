<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_role')->insert([
            [
                'permission_id' => DB::table('permissions')->where('title', 'dashboard_access')->first()->id,
                'role_id' => DB::table('roles')->where('title', 'admin')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'permission_id' => DB::table('permissions')->where('title', 'users_management_access')->first()->id,
                'role_id' => DB::table('roles')->where('title', 'admin')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'permission_id' => DB::table('permissions')->where('title', 'requests_access')->first()->id,
                'role_id' => DB::table('roles')->where('title', 'admin')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'permission_id' => DB::table('permissions')->where('title', 'books_access')->first()->id,
                'role_id' => DB::table('roles')->where('title', 'admin')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'permission_id' => DB::table('permissions')->where('title', 'ebooks_access')->first()->id,
                'role_id' => DB::table('roles')->where('title', 'admin')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'permission_id' => DB::table('permissions')->where('title', 'promotions_access')->first()->id,
                'role_id' => DB::table('roles')->where('title', 'admin')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'permission_id' => DB::table('permissions')->where('title', 'authors_access')->first()->id,
                'role_id' => DB::table('roles')->where('title', 'admin')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'permission_id' => DB::table('permissions')->where('title', 'genres_access')->first()->id,
                'role_id' => DB::table('roles')->where('title', 'admin')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'permission_id' => DB::table('permissions')->where('title', 'rental_access')->first()->id,
                'role_id' => DB::table('roles')->where('title', 'user')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'permission_id' => DB::table('permissions')->where('title', 'user_dashboard_access')->first()->id,
                'role_id' => DB::table('roles')->where('title', 'user')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'permission_id' => DB::table('permissions')->where('title', 'profile_access')->first()->id,
                'role_id' => DB::table('roles')->where('title', 'user')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'permission_id' => DB::table('permissions')->where('title', 'activity_access')->first()->id,
                'role_id' => DB::table('roles')->where('title', 'user')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'permission_id' => DB::table('permissions')->where('title', 'notifications_access')->first()->id,
                'role_id' => DB::table('roles')->where('title', 'user')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'permission_id' => DB::table('permissions')->where('title', 'coupons_access')->first()->id,
                'role_id' => DB::table('roles')->where('title', 'user')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'permission_id' => DB::table('permissions')->where('title', 'coupons_access')->first()->id,
                'role_id' => DB::table('roles')->where('title', 'admin')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'permission_id' => DB::table('permissions')->where('title', 'call_a_friend_access')->first()->id,
                'role_id' => DB::table('roles')->where('title', 'user')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'permission_id' => DB::table('permissions')->where('title', 'pay_membership_access')->first()->id,
                'role_id' => DB::table('roles')->where('title', 'user')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);
    }
}
