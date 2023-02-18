<?php

namespace Tests\Feature\Posts;

use Lunacms\Forums\Models\Forum;
use Lunacms\Forums\Models\Post;
use Lunacms\Forums\Tests\Models\User;
use Lunacms\Forums\Tests\TestCase;

class PostStoreTest extends TestCase
{
    public function test_it_requires_a_title()
    {
        $forum = Forum::factory()->for(User::factory(), 'forumable')->create();

        $response = $this->useLogin()->postJson(
            $this->forumsUrl('/posts', $forum->slug)
        );

        $response->assertJsonValidationErrors([
            'title'
        ]);
    }

    public function test_it_requires_a_body()
    {
        $forum = Forum::factory()->for(User::factory(), 'forumable')->create();

        $response = $this->useLogin()->postJson(
            $this->forumsUrl('/posts', $forum->slug)
        );

        $response->assertJsonValidationErrors([
            'body'
        ]);
    }

    public function test_it_stores_a_post()
    {
        $forum = Forum::factory()->for(User::factory(), 'forumable')->create();

        $this->useLogin()->postJson(
            $this->forumsUrl('/posts', $forum->slug), $payload = [
                'title' => 'Demo Post',
                'body' => 'Demo post body',
            ]
        );

        $post = (new Post)->owner()->associate($this->authUser());

        $this->assertDatabaseHas('forum_posts', array_merge(
            $payload, $post->only(['owner_id', 'owner_type'])
        ));
    }

    public function test_it_returns_a_post_when_created()
    {
        $forum = Forum::factory()->for(User::factory(), 'forumable')->create();

        $response = $this->useLogin()->postJson(
            $this->forumsUrl('/posts', $forum->slug), $payload = [
                'title' => 'Demo Post',
                'body' => 'Demo post body',
            ]
        );

        $response->assertJsonFragment(array_merge(
            $payload, [
            'id' => json_decode($response->getContent())->data->id,
        ]));
    }
}
