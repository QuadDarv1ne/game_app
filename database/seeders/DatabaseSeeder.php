<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use Database\Factories\PostTagsFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            CategorySeeder::class,
            TagSeeder::class,
            UserSeeder::class,
            PostSeeder::class,
            PostTagsSeeder::class,
            CommentSeeder::class,
        ]);

    }
}
