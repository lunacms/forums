<?php

namespace Tests\Feature\Tags;

use Lunacms\Forums\Models\Tag;
use Lunacms\Forums\Tests\TestCase;

class TagIndexTest extends TestCase
{
    public function test_it_shows_tags()
    {
        $tag = Tag::factory()->create();

        $response = $this->useLogin()->getJson(
            $this->wrapUrl('/tags')
        );

        $response->assertJsonFragment([
            'slug' => $tag->slug,
        ]);

        $response->assertJsonPath('data.0.id', $tag->id);
    }
}
