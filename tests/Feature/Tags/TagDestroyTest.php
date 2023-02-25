<?php

namespace Tests\Feature\Tags;

use Lunacms\Forums\Tags\Models\Tag;
use Lunacms\Forums\Tests\TestCase;

class TagDestroyTest extends TestCase
{
    public function test_tag_is_deleted()
    {
        $tag = Tag::factory()->create();

        $response = $this->useLogin()->deleteJson(
            $this->wrapUrl('/tags/' . $tag->slug)
        );

        $response->assertNoContent();

        $this->assertSoftDeleted($tag);
    }
}
