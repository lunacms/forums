<?php

namespace Tests\Feature\Posts;

use Lunacms\Forums\Forums\Models\Forum;
use Lunacms\Forums\Posts\Models\Post;
use Lunacms\Forums\Tests\Models\User;
use Lunacms\Forums\Tests\TestCase;

class PostIndexTest extends TestCase
{
    public function test_it_shows_posts()
    {
        $forum = Forum::factory()->for(User::factory(), 'forumable')->create();

        $post = Post::factory()->for($this->authUser(), 'owner')->create([
        	'forum_id' => $forum->id
        ]);

        $response = $this->useLogin()->getJson(
            $this->forumsUrl('/posts', $forum->slug)
        );

        $response->assertJsonFragment([
            'slug' => $post->slug,
        ]);

        $response->assertJsonPath('data.0.id', $post->id);
    }
}
