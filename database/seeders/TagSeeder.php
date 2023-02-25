<?php

namespace Lunacms\Forums\Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Lunacms\Forums\Forums;
use Lunacms\Forums\Forums\Models\Forum;
use Lunacms\Forums\Posts\Models\Post;
use Lunacms\Forums\Tags\Models\Tag;

class TagSeeder extends Seeder
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
            Tag::factory()->count(5)
            	->has(Forum::factory()->for($model::factory(), 'forumable')) 
            	->create();
        }

        Tag::factory()->count(5)
        	->has(
        		Post::factory()->for($model::factory(), 'owner')
        	)
        	->create();
    }
}
