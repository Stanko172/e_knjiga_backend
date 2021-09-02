<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('e_books')->insert([
            'name' => 'Don Quixote',
            'description' => 'Lorem ipsum dolor sit amet, novum hendrerit at sea, omnes evertitur assentior eum te, vim altera delectus splendide ne. Ius nostro impedit appellantur at. Quod eleifend molestiae cum te. Suas latine te sea, ius eu etiam oratio assentior.',
            'price' => 30.80      
        ]);
        DB::table('e_books')->insert([
            'name' => 'Lord of the Rings',
            'description' => 'Lorem ipsum dolor sit amet, novum hendrerit at sea, omnes evertitur assentior eum te, vim altera delectus splendide ne. Ius nostro impedit appellantur at. Quod eleifend molestiae cum te. Suas latine te sea, ius eu etiam oratio assentior.',
            'price' => 17.90      
        ]);
        DB::table('e_books')->insert([
            'name' => "Harry Potter and the Sorcerer's Stone",
            'description' => 'Lorem ipsum dolor sit amet, novum hendrerit at sea, omnes evertitur assentior eum te, vim altera delectus splendide ne. Ius nostro impedit appellantur at. Quod eleifend molestiae cum te. Suas latine te sea, ius eu etiam oratio assentior.',
            'price' => 27.10      
        ]);
        DB::table('e_books')->insert([
            'name' => "Alice's Adventures in Wonderland",
            'description' => 'Lorem ipsum dolor sit amet, novum hendrerit at sea, omnes evertitur assentior eum te, vim altera delectus splendide ne. Ius nostro impedit appellantur at. Quod eleifend molestiae cum te. Suas latine te sea, ius eu etiam oratio assentior.',
            'price' => 9.50      
        ]);
        DB::table('e_books')->insert([
            'name' => 'Pinocchio',
            'description' => 'Lorem ipsum dolor sit amet, novum hendrerit at sea, omnes evertitur assentior eum te, vim altera delectus splendide ne. Ius nostro impedit appellantur at. Quod eleifend molestiae cum te. Suas latine te sea, ius eu etiam oratio assentior.',
            'price' => 10.99      
        ]);
        DB::table('e_books')->insert([
            'name' => 'Fantastic Beats and Where to Find Them',
            'description' => 'Lorem ipsum dolor sit amet, novum hendrerit at sea, omnes evertitur assentior eum te, vim altera delectus splendide ne. Ius nostro impedit appellantur at. Quod eleifend molestiae cum te. Suas latine te sea, ius eu etiam oratio assentior.',
            'price' => 13.99      
        ]);
    }
}
