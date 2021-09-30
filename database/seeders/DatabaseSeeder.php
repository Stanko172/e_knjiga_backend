<?php

namespace Database\Seeders;

use App\Models\BookImage;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            PermissionRoleSeeder::class,
            RoleUserSeeder::class,
            ShopOfficeSeeder::class,
            Membership_cardSeeder::class,
            GenreSeeder::class,
            BookSeeder::class,
            WriterSeeder::class,
            Book_genreSeeder::class,
            Book_writerSeeder::class,
            RequestSeeder::class,
            EbookSeeder::class,
            Ebook_writerSeeder::class,
            Ebook_genreSeeder::class,
            BookRatingSeeder::class,
            EBookRatingSeeder::class,
            CouponSeeder::class,
            BookImageSeeder::class
        ]);
    }
}