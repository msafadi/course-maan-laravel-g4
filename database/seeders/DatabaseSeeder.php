<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //User::factory(1)->create();
        //Category::factory(5)->create();

        //Tag::factory(10)->create();

        $this->call([
            //PostsTableSeeder::class,
            AbilitiesTableSeeder::class,
        ]);
    }
}
