<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('relations')->insert([
            'book_id' => 1,
            'author_id' => 1
        ]);
        DB::table('relations')->insert([
            'book_id' => 2,
            'author_id' => 2
        ]);
        DB::table('relations')->insert([
            'book_id' => 3,
            'author_id' => 4
        ]);
        DB::table('relations')->insert([
            'book_id' => 4,
            'author_id' => 4
        ]);
        DB::table('relations')->insert([
            'book_id' => 5,
            'author_id' => 5
        ]);
        DB::table('relations')->insert([
            'book_id' => 6,
            'author_id' => 6
        ]);
        DB::table('relations')->insert([
            'book_id' => 7,
            'author_id' => 7
        ]);
        DB::table('relations')->insert([
            'book_id' => 8,
            'author_id' => 8
        ]);
        DB::table('relations')->insert([
            'book_id' => 9,
            'author_id' => 9
        ]);
        DB::table('relations')->insert([
            'book_id' => 10,
            'author_id' => 10
        ]);
    }
}
