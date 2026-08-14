<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class PostTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = Tag::all();

        if ($tags->isEmpty()) {
            return;
        }

        Post::all()->each(function (Post $post) use ($tags) {
            $randomTagIds = $tags->random(rand(1, 4))->pluck('id');

            $post->tags()->attach($randomTagIds);
        });
    }
}
