<?php

namespace Tests\Feature\Posts;

use Lunacms\Forums\Models\Post;
use Lunacms\Forums\Tests\Models\User;
use Lunacms\Forums\Tests\TestCase;

class PostUpdateTest extends TestCase
{
    public function test_it_requires_a_title()
    {
        $post = Post::factory()->for(User::factory(), 'owner')->create();

        $response = $this->useLogin()->patchJson(
            $this->wrapUrl('/posts/' . $post->slug)
        );

        $response->assertJsonValidationErrors([
            'title'
        ]);
    }

    public function test_it_requires_a_body()
    {
        $post = Post::factory()->for(User::factory(), 'owner')->create();

        $response = $this->useLogin()->patchJson(
            $this->wrapUrl('/posts/' . $post->slug)
        );

        $response->assertJsonValidationErrors([
            'body'
        ]);
    }

    public function test_it_updates_a_post()
    {
        $post = Post::factory()->for(User::factory(), 'owner')->create();

        $this->useLogin()->patchJson(
            $this->wrapUrl('/posts/' . $post->slug), $payload = [
                'title' => 'Demo Post',
                'body' => 'Demo post body',
            ]
        );

        $this->assertDatabaseHas('forum_posts', array_merge(
            $payload, [
                'id' => $post->id,
            ]
        ));
    }

    public function test_it_returns_a_post_when_updated()
    {
        $post = Post::factory()->for(User::factory(), 'owner')->create();

        $response = $this->useLogin()->patchJson(
            $this->wrapUrl('/posts/' . $post->slug), $payload = [
                'title' => 'Demo Post Updated',
                'body' => 'Demo post body updated',
            ]
        );

        $response->assertJsonFragment(array_merge(
            $payload, [
            'id' => json_decode($response->getContent())->data->id,
        ]));
    }
}
