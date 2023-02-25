<?php

namespace Tests\Feature\Forums;

use Lunacms\Forums\Forums\Models\Forum;
use Lunacms\Forums\Tests\TestCase;

class ForumShowTest extends TestCase
{
    public function test_it_shows_the_correct_forum()
    {
        $forum = Forum::factory()->for($this->authUser(), 'forumable')->create();

        $response = $this->useLogin()->getJson(
            $this->wrapUrl('/forums/' . $forum->slug)
        );

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'id' => json_decode($response->getContent())->data->id,
            'name' => $forum->name,
            'slug' => $forum->slug,
        ]);
    }
}
