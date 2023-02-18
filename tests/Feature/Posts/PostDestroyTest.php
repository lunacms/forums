<?php

namespace Tests\Feature\Posts;

use Lunacms\Forums\Models\Post;
use Lunacms\Forums\Tests\TestCase;

class PostDestroyTest extends TestCase
{
    public function test_post_is_deleted()
    {
        $post = Post::factory()->for($this->authUser(), 'owner')->create();

        $response = $this->useLogin()->deleteJson(
            $this->wrapUrl('/posts/' . $post->slug)
        );

        $response->assertNoContent();

        $this->assertSoftDeleted($post);
    }
}
