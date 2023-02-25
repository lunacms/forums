<?php

namespace Lunacms\Forums\Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Lunacms\Forums\Forums;
use Lunacms\Forums\Comments\Models\Comment;
use Lunacms\Forums\Forums\Models\Forum;
use Lunacms\Forums\Posts\Models\Post;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = config('forums.models.users');

        if (!Forums::runningSingleMode()) {
            Forum::factory()->count(3)
                ->for($model::factory(), 'forumable')
                ->has(
                    Post::factory()->count(5)
                        ->for($model::factory(), 'owner')
                        ->has(
                            Comment::factory()
                                ->for(
                                    $model::factory(), 'owner'
                                )->count(3),
                            'comments'
                        )
                    )->create(); 
        }
    }
}
