<?php

namespace Tests\Unit;

use Lunacms\Forums\Forums\Models\Forum;
use Lunacms\Forums\Posts\Models\Post;
use Lunacms\Forums\Tags\Models\Tag;
use Lunacms\Forums\Tests\Models\User;
use Lunacms\Forums\Tests\TestCase;

class TagTest extends TestCase
{
    public function test_route_key_name_is_slug()
    {
        $this->assertEquals((new Tag())->getRouteKeyName(), 'slug');
    }

    public function test_it_has_many_forums()
    {
    	$tag = Tag::factory()
    				->has(Forum::factory()->for(User::factory(), 'forumable'))
    				->create();

    	$this->assertInstanceOf(Forum::class, $tag->forums->first());
    }

    public function test_it_has_many_posts()
    {
    	$tag = Tag::factory()
    				->has(Post::factory()->for(User::factory(), 'owner'))
    				->create();

    	$this->assertInstanceOf(Post::class, $tag->posts->first());
    }
}
