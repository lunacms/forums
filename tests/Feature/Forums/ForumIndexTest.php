<?php

namespace Tests\Feature\Forums;

use Lunacms\Forums\Forums;
use Lunacms\Forums\Forums\Models\Forum;
use Lunacms\Forums\Tests\TestCase;

class ForumIndexTest extends TestCase
{
    public function test_it_shows_forums()
    {
        if (Forums::runningSingleMode()) {
            return $this->markTestSkipped('Forums running in [single] mode.');
        }

        $forum = Forum::factory()->for($this->authUser(), 'forumable')->create();

        $response = $this->getJson($this->wrapUrl('/forums'));

        $response->assertJsonFragment([
            'slug' => $forum->slug,
        ]);

        $response->assertJsonPath('data.0.id', $forum->id);
    }
}
