<?php

namespace Tests\Unit;

use Lunacms\Forums\Comments\Models\Comment;
use Lunacms\Forums\Forums\Models\Forum;
use Lunacms\Forums\Posts\Models\Post;
use Lunacms\Forums\Tags\Models\Tag;
use Lunacms\Forums\Tests\Models\User;
use Lunacms\Forums\Tests\TestCase;

class PostTest extends TestCase
{
    public function test_it_has_route_key_name()
    {
        $this->assertEquals((new Post())->getRouteKeyName(), 'slug');
    }

    public function test_it_belongs_to_a_forum()
    {
    	$post = Post::factory()->for(User::factory(), 'owner')->create();

        $this->assertInstanceOf(Forum::class, $post->forum);
    }

    public function test_slug_starts_with_forum_id()
    {
    	$post = Post::factory()->for(User::factory(), 'owner')->create();

        $this->assertStringStartsWith($post->forum->id, $post->slug);
    }

    public function test_it_has_an_owner()
    {
    	$post = Post::factory()->for(User::factory(), 'owner')->create();

        $this->assertInstanceOf(User::class, $post->owner);
    }

    public function test_has_many_tags()
    {
    	$post = Post::factory()
    				->for(User::factory(), 'owner')
    				->has(
			    		Tag::factory()->count(3), 'tags'
			    	)->create();

    	$this->assertInstanceOf(Tag::class, $post->tags->first());
    }

    public function test_has_many_comments()
    {
    	$post = Post::factory()
    				->for(User::factory(), 'owner')
    				->has(
			    		Comment::factory()
			    			->for(
			    				Forum::factory()->for(User::factory(), 'forumable'), 'owner'
				    		)->count(3), 'comments'
			    	)->create();

    	$this->assertInstanceOf(Comment::class, $post->comments->first());
    }

    public function test_can_add_tags_via_trait()
    {
        $user = User::factory();

        $forum = Post::factory()->for($user, 'owner')->create();

        $forum->addTags(Tag::factory()->count(3)->create()->pluck('id')->all());

        $this->assertCount(3, $forum->fresh(['tags'])->tags);

        $this->assertInstanceOf(Tag::class, $forum->tags->first());
    }

    public function test_can_detach_tags_via_trait()
    {
        $user = User::factory();

        $forum = Post::factory()->for($user, 'owner')->create();

        $forum->addTags(($tags = Tag::factory()->count(3)->create()->pluck('id')->all()));

        $forum->detachTags($tags);

        $this->assertCount(0, $forum->fresh(['tags'])->tags);

        $this->assertEmpty($forum->tags);
    }

    public function test_can_sync_tags_via_trait()
    {
        $user = User::factory();

        $forum = Post::factory()->for($user, 'owner')->create();

        $forum->addTags(($tags = Tag::factory()->count(3)->create()->pluck('id')->all()));

        $newTags = Tag::factory()->count(2)->create()->pluck('id')->all();

        $forum->syncTags(array_merge(array_slice($tags, 1), $newTags));

        $this->assertCount(4, $forum->fresh(['tags'])->tags);

        $this->assertContains(last($newTags), $forum->fresh(['tags'])->tags->pluck('id')->all());
    }
}
