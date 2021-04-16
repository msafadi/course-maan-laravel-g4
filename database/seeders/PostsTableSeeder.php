<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Post::create([
            'title' => 'Post Title',
            'slug' => Str::slug('Post Title'),
            'content' => 'Post long text content',
            'category_id' => 1,
            'user_id' => 1,
            'status' => 'draft',
        ]);*/
        Post::factory(10)->create();
    }
}
