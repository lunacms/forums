<?php

namespace Tests\Feature\Comments;

use Lunacms\Forums\Models\Comment;
use Lunacms\Forums\Models\Post;
use Lunacms\Forums\Tests\TestCase;

class CommentDestroyTest extends TestCase
{
    public function test_comment_is_deleted()
    {
        $comment = Comment::factory()->for(
                Post::factory()->for($this->authUser(), 'owner'), 'commentable'
            )->for($this->authUser(), 'owner')->create();

        $response = $this->useLogin()->deleteJson(
            $this->wrapUrl('/comments/' . $comment->id)
        );

        $response->assertNoContent();

        $this->assertSoftDeleted($comment);
    }
}
