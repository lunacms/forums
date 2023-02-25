<?php

namespace Tests\Feature\Comments;

use Lunacms\Forums\Comments\Models\Comment;
use Lunacms\Forums\Posts\Models\Post;
use Lunacms\Forums\Tests\TestCase;

class CommentUpdateTest extends TestCase
{
    public function test_it_requires_a_body()
    {
        $comment = Comment::factory()->for(
                Post::factory()->for($this->authUser(), 'owner'), 'commentable'
            )->for($this->authUser(), 'owner')->create();

        $response = $this->useLogin()->patchJson(
            $this->wrapUrl('/comments/' . $comment->id)
        );

        $response->assertJsonValidationErrors([
            'body'
        ]);
    }

    public function test_it_updates_a_comment()
    {
        $comment = Comment::factory()->for(
                Post::factory()->for($this->authUser(), 'owner'), 'commentable'
            )->for($this->authUser(), 'owner')->create();

        $this->useLogin()->patchJson(
            $this->wrapUrl('/comments/' . $comment->id), $payload = [
                'body' => 'Demo comment body',
            ]
        );

        $this->assertDatabaseHas('forum_comments', array_merge(
            $payload, [
                'id' => $comment->id,
            ]
        ));
    }

    public function test_it_returns_a_comment_when_updated()
    {
        $comment = Comment::factory()->for(
                Post::factory()->for($this->authUser(), 'owner'), 'commentable'
            )->for($this->authUser(), 'owner')->create();

        $response = $this->useLogin()->patchJson(
            $this->wrapUrl('/comments/' . $comment->id), $payload = [
                'body' => 'Demo comment body updated',
            ]
        );

        $response->assertJsonFragment(array_merge(
            $payload, [
            'id' => json_decode($response->getContent())->data->id,
        ]));
    }
}
