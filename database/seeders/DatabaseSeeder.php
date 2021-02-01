<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Relation;
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
        Author::factory(10)->create();
        Book::factory(10)->create();
        Relation::factory(10)->create();
        $this->call([
            UserSeeder::class,
            RelationSeeder::class
        ]);
    }
}
