<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbilitiesTableSeeder extends Seeder
{

    protected $abilities = [
        'posts.view-any' => 'Can view any post.',
        'posts.view' => 'Can view post.',
        'posts.create' => 'Can create new post.',
        'posts.update' => 'Can update post.',
        'posts.delete' => 'Can delete post.',
        'posts.restore' => 'Can restore a deleted post.',
        'posts.force-delete' => 'Can force delete post.',
        'categories.create' => 'Can create new category.',
        'categories.update' => 'Can update category.',
        'categories.delete' => 'Can delete category.',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->abilities as $code => $name) {
            DB::table('abilities')->insert([
                'code' => $code,
                'name' => $name,
            ]);
        }
    }
}
