<?php

namespace Tests\Feature\Forums;

use Lunacms\Forums\Forums;
use Lunacms\Forums\Models\Forum;
use Lunacms\Forums\Tests\TestCase;

class ForumStoreTest extends TestCase
{
    public function test_it_requires_a_name()
    {
        if (Forums::runningSingleMode()) {
            return $this->markTestSkipped();
        }

        $response = $this->useLogin()->postJson(
            $this->wrapUrl('/forums')
        );

        $response->assertJsonValidationErrors([
            'name'
        ]);
    }

    public function test_it_stores_a_forum()
    {
        if (Forums::runningSingleMode()) {
            return $this->markTestSkipped();
        }

        $this->useLogin()->postJson(
            $this->wrapUrl('/forums'), $payload = [
                'name' => 'Demo',
            ]
        );

        $post = (new Forum)->forumable()->associate($this->authUser());

        $this->assertDatabaseHas('forums', array_merge(
            $payload, $post->only(['forumable_id', 'forumable_type'])
        ));
    }

    public function test_it_returns_a_forum_when_created()
    {
        if (Forums::runningSingleMode()) {
            return $this->markTestSkipped();
        }

        $payload = Forum::factory()->make()->only(['name']);

        $response = $this->useLogin()->postJson(
            $this->wrapUrl('/forums'), $payload
        );

        $response->assertJsonFragment(array_merge(
            $payload, [
            'id' => json_decode($response->getContent())->data->id,
        ]));
    }
}
