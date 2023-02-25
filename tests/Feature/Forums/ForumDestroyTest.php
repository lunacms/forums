<?php

namespace Tests\Feature\Forums;

use Lunacms\Forums\Forums\Models\Forum;
use Lunacms\Forums\Tests\TestCase;

class ForumDestroyTest extends TestCase
{
    public function test_it_forum_is_deleted()
    {
        $forum = Forum::factory()->for($this->authUser(), 'forumable')->create();

        $response = $this->useLogin()->deleteJson(
            $this->wrapUrl('/forums/' . $forum->slug)
        );

        $response->assertNoContent();

        $this->assertSoftDeleted($forum);
    }
}
