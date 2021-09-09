<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([
            'name' => 'Don Quijote',
            'description' => 'Lorem ipsum dolor sit amet, novum hendrerit at sea, omnes evertitur assentior eum te, vim altera delectus splendide ne. Ius nostro impedit appellantur at. Quod eleifend molestiae cum te. Suas latine te sea, ius eu etiam oratio assentior.',
            'year' => 1605,
            'amount' => 10,
            'price' => 30.80      
        ]);
        DB::table('books')->insert([
            'name' => 'Lord of the Rings',
            'year' => 1954,
            'description' => 'Lorem ipsum dolor sit amet, novum hendrerit at sea, omnes evertitur assentior eum te, vim altera delectus splendide ne. Ius nostro impedit appellantur at. Quod eleifend molestiae cum te. Suas latine te sea, ius eu etiam oratio assentior.',
            'amount' => 10,
            'price' => 17.90      
        ]);
        DB::table('books')->insert([
            'name' => "Harry Potter and the Sorcerer's Stone",
            'year' => 1997,
            'description' => 'Lorem ipsum dolor sit amet, novum hendrerit at sea, omnes evertitur assentior eum te, vim altera delectus splendide ne. Ius nostro impedit appellantur at. Quod eleifend molestiae cum te. Suas latine te sea, ius eu etiam oratio assentior.',
            'amount' => 10,
            'price' => 27.10      
        ]);
        DB::table('books')->insert([
            'name' => "Alice's Adventures in Wonderland",
            'year' => 1865,
            'description' => 'Lorem ipsum dolor sit amet, novum hendrerit at sea, omnes evertitur assentior eum te, vim altera delectus splendide ne. Ius nostro impedit appellantur at. Quod eleifend molestiae cum te. Suas latine te sea, ius eu etiam oratio assentior.',
            'amount' => 10,
            'price' => 9.50      
        ]);
        DB::table('books')->insert([
            'name' => 'Pinocchio',
            'year' => 1881,
            'description' => 'Lorem ipsum dolor sit amet, novum hendrerit at sea, omnes evertitur assentior eum te, vim altera delectus splendide ne. Ius nostro impedit appellantur at. Quod eleifend molestiae cum te. Suas latine te sea, ius eu etiam oratio assentior.',
            'amount' => 10,
            'price' => 10.99      
        ]);
        DB::table('books')->insert([
            'name' => 'Fantastic Beasts and Where to Find Them',
            'year' => 2001,
            'description' => 'Lorem ipsum dolor sit amet, novum hendrerit at sea, omnes evertitur assentior eum te, vim altera delectus splendide ne. Ius nostro impedit appellantur at. Quod eleifend molestiae cum te. Suas latine te sea, ius eu etiam oratio assentior.',
            'amount' => 10,
            'price' => 13.99      
        ]);
    }
}
