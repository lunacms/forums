<?php

namespace Tests\Feature\Posts;

use Lunacms\Forums\Models\Forum;
use Lunacms\Forums\Models\Post;
use Lunacms\Forums\Tests\Models\User;
use Lunacms\Forums\Tests\TestCase;

class PostShowTest extends TestCase
{
    public function test_it_shows_a_post()
    {
        $forum = Forum::factory()->for(User::factory(), 'forumable')->create();
        $post = Post::factory()->for($this->authUser(), 'owner')->create();

        $response = $this->useLogin()->getJson(
            $this->forumsUrl('/posts/' . $post->slug, $forum->slug)
        );

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'id' => json_decode($response->getContent())->data->id,
            'title' => $post->title,
            'slug' => $post->slug,
        ]);
    }
}
