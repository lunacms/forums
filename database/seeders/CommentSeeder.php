<?php

namespace Lunacms\Forums\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Lunacms\Forums\Comments\Models\Comment;
use Lunacms\Forums\Forums\Models\Forum;
use Lunacms\Forums\Posts\Models\Post;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = config('forums.models.users');

        Comment::factory()
            ->count(20)
            ->for(
                Post::factory()->for($model::factory(), 'owner'), 'commentable'
            )
            ->for(
                Forum::factory()->for($model::factory(), 'forumable'), 'owner'
            )
            ->create();
    }
}
