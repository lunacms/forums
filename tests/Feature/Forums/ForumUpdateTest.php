<?php

namespace Tests\Feature\Forums;

use Lunacms\Forums\Forums;
use Lunacms\Forums\Forums\Models\Forum;
use Lunacms\Forums\Tests\TestCase;

class ForumUpdateTest extends TestCase
{
    public function test_it_requires_a_name()
    {
        if (Forums::runningSingleMode()) {
            return $this->markTestSkipped('Forums running in [single] mode.');
        }

        $forum = Forum::factory()->for($this->authUser(), 'forumable')->create();

        $response = $this->useLogin()->patchJson(
            $this->wrapUrl('/forums/' . $forum->slug)
        );

        $response->assertJsonValidationErrors([
            'name'
        ]);
    }

    public function test_it_updates_a_forum()
    {
        if (Forums::runningSingleMode()) {
            return $this->markTestSkipped('Forums running in [single] mode.');
        }

        $forum = Forum::factory()->for($this->authUser(), 'forumable')->create();

        $this->useLogin()->patchJson(
            $this->wrapUrl('/forums/' . $forum->slug), $payload = [
                'name' => 'Demo updated!!!',
            ]
        );


        $this->assertDatabaseHas('forums', array_merge(
            $payload, [
                'id' => $forum->id,
            ]
        ));
    }

    public function test_it_returns_a_forum_when_updated()
    {
        if (Forums::runningSingleMode()) {
            return $this->markTestSkipped('Forums running in [single] mode.');
        }

        $forum = Forum::factory()->for($this->authUser(), 'forumable')->create();

        $response = $this->useLogin()->patchJson(
            $this->wrapUrl('/forums/' . $forum->slug), $payload = ['name' => 'Updated Demo']
        );

        $response->assertJsonFragment(array_merge(
            $payload, [
            'id' => json_decode($response->getContent())->data->id,
        ]));
    }
}
