<?php

namespace Tests\Feature\Posts;

use Lunacms\Forums\Comments\Models\Comment;
use Lunacms\Forums\Posts\Models\Post;
use Lunacms\Forums\Tests\Models\User;
use Lunacms\Forums\Tests\TestCase;

class PostCommentsTest extends TestCase
{
    public function test_it_shows_comments()
    {
        $post = Post::factory()->for(User::factory(), 'owner')
            ->has(Comment::factory()->for(User::factory(), 'owner')->count(3), 'comments')
            ->create();

        $response = $this->useLogin()->getJson(
            $this->wrapUrl('/posts/' . $post->slug . '/comments')
        );

        $response->assertJsonPath('data.0.id', $post->comments->first()->id);
    }
}
