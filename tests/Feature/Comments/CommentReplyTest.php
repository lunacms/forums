<?php

namespace Tests\Feature\Comments;

use Lunacms\Forums\Models\Comment;
use Lunacms\Forums\Models\Post;
use Lunacms\Forums\Tests\TestCase;

class CommentReplyTest extends TestCase
{
    public function test_it_requires_a_body()
    {
        $comment = Comment::factory()->for(
                Post::factory()->for($this->authUser(), 'owner'), 'commentable'
            )->for($this->authUser(), 'owner')->create();

        $response = $this->useLogin()->postJson(
            $this->wrapUrl('/comments/' . $comment->id . '/replies')
        );

        $response->assertJsonValidationErrors([
            'body'
        ]);
    }

    public function test_it_stores_a_comment_reply()
    {
        $comment = Comment::factory()->for(
                Post::factory()->for($this->authUser(), 'owner'), 'commentable'
            )->for($this->authUser(), 'owner')->create();

        $response = $this->useLogin()->postJson(
            $this->wrapUrl('/comments/' . $comment->id . '/replies'), $payload = [
                'body' => 'Demo comment body',
            ]
        );

        $this->assertDatabaseHas('forum_comments', array_merge(
            $payload, [
                'id' => json_decode($response->getContent())->data->id,
            ]
        ));
    }

    public function test_it_returns_a_comment_on_reply()
    {
        $comment = Comment::factory()->for(
                Post::factory()->for($this->authUser(), 'owner'), 'commentable'
            )->for($this->authUser(), 'owner')->create();

        $response = $this->useLogin()->postJson(
            $this->wrapUrl('/comments/' . $comment->id . '/replies'), $payload = [
                'body' => 'Demo comment body replied',
            ]
        );

        $response->assertJsonFragment(array_merge(
            $payload, [
            'id' => json_decode($response->getContent())->data->id,
        ]));
    }
}
