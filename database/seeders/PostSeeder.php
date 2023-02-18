<?php

namespace Lunacms\Forums\Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Lunacms\Forums\Models\Comment;
use Lunacms\Forums\Models\Post;
use Lunacms\Forums\Models\Tag;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = config('forums.models.users');

        Post::factory()
            ->count(3)
            ->for($model::factory(), 'owner')
            ->has(
                Tag::factory()->count(3), 'tags'
            )
            ->has(
                Comment::factory()
                    ->for(
                        $model::factory(), 'owner'
                    )->count(3), 'comments'
            )->create();
    }
}
