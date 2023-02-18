<?php

namespace Lunacms\Forums\Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call([
            TagSeeder::class,
            ForumSeeder::class,
            // PostSeeder::class,
            // CommentSeeder::class,
        ]);
    }
}
