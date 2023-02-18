<?php

namespace Tests\Feature\Tags;

use Lunacms\Forums\Tests\TestCase;

class TagStoreTest extends TestCase
{
    public function test_it_requires_a_name()
    {
        $response = $this->useLogin()->postJson(
            $this->wrapUrl('/tags')
        );

        $response->assertJsonValidationErrors([
            'name'
        ]);
    }

    public function test_it_stores_a_tag()
    {
        $response = $this->useLogin()->postJson(
           $this->wrapUrl('/tags'), $payload = [
                'name' => 'Tag Demo',
            ]
        );

        $this->assertDatabaseHas('forum_tags', array_merge(
            $payload, [
                'id' => json_decode($response->getContent())->data->id,
            ]
        ));
    }

    public function test_it_returns_a_tag_when_created()
    {
        $response = $this->useLogin()->postJson(
           $this->wrapUrl('/tags'), $payload = [
                'name' => 'Tag 2',
            ]
        );

        $response->assertJsonFragment(array_merge(
            $payload, [
            'id' => json_decode($response->getContent())->data->id,
        ]));
    }
}
