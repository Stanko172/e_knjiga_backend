<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WriterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('writers')->insert([
            'name' => 'Carlo',
            'surname' => 'Collodi',
            'bday' => Carbon::create('1826', '11', '24'),
            'dday' => Carbon::create('1890', '10', '26'),
        ]);
        DB::table('writers')->insert([
            'name' => 'Lewis',
            'surname' => 'Carroll',
            'bday' => Carbon::create('1832', '01', '04'),
            'dday' => Carbon::create('1898', '01', '14'),
        ]);
        DB::table('writers')->insert([
            'name' => 'Joanne',
            'surname' => 'Rowling',
            'bday' => Carbon::create('1965', '07', '31'),
            'dday' => NULL,
        ]);
        DB::table('writers')->insert([
            'name' => 'John Ronald Reuel',
            'surname' => 'Tolkien',
            'bday' => Carbon::create('1892', '01', '03'),
            'dday' => Carbon::create('1973', '09', '02'),
        ]);
        DB::table('writers')->insert([
            'name' => 'Miguel',
            'surname' => 'de Cervantes',
            'bday' => Carbon::create('1547', '09', '29'),
            'dday' => Carbon::create('1616', '04', '23'),
        ]);
    }
}
