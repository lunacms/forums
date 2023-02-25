<?php

namespace Lunacms\Forums\Tests\Unit;

use Lunacms\Forums\Comments\Models\Comment;
use Lunacms\Forums\Forums\Models\Forum;
use Lunacms\Forums\Posts\Models\Post;
use Lunacms\Forums\Tags\Models\Tag;
use Lunacms\Forums\Tests\Models\User;
use Lunacms\Forums\Tests\TestCase;

class ForumTest extends TestCase
{
    public function test_can_uses_slug_as_route_key()
    {
        $this->assertEquals((new Forum())->getRouteKeyName(), 'slug');
    }

    public function test_has_owner()
    {
    	$user = User::factory();

    	$forum = Forum::factory()->for($user, 'forumable')->create();

    	$this->assertInstanceOf(User::class, $forum->forumable);
    }

    public function test_has_many_posts()
    {
    	$forum = Forum::factory()
    				->for(User::factory(), 'forumable')
    				->has(
			    		Post::factory()->for(User::factory(), 'owner')->count(3), 'posts'
			    	)->create();

    	$this->assertInstanceOf(Post::class, $forum->posts->first());
    }

    public function test_has_many_tags()
    {
    	$forum = Forum::factory()
    				->for(User::factory(), 'forumable')
    				->has(
			    		Tag::factory()->count(3), 'tags'
			    	)->create();

    	$this->assertInstanceOf(Tag::class, $forum->tags->first());
    }

    public function test_has_many_comments()
    {
    	$forum = Forum::factory()
    				->for(User::factory(), 'forumable')
    				->has(
			    		Comment::factory()
			    			->for(
			    				Forum::factory()->for(User::factory(), 'forumable'), 'owner'
				    		)->count(3), 'comments'
			    	)->create();

    	$this->assertInstanceOf(Comment::class, $forum->comments->first());
    }

    public function test_can_add_tags_via_trait()
    {
        $user = User::factory();

        $forum = Forum::factory()->for($user, 'forumable')->create();

        $forum->addTags(Tag::factory()->count(3)->create()->pluck('id')->all());

        $this->assertCount(3, $forum->fresh(['tags'])->tags);

        $this->assertInstanceOf(Tag::class, $forum->tags->first());
    }

    public function test_can_detach_tags_via_trait()
    {
        $user = User::factory();

        $forum = Forum::factory()->for($user, 'forumable')->create();

        $forum->addTags(($tags = Tag::factory()->count(3)->create()->pluck('id')->all()));

        $forum->detachTags($tags);

        $this->assertCount(0, $forum->fresh(['tags'])->tags);

        $this->assertEmpty($forum->tags);
    }

    public function test_can_sync_tags_via_trait()
    {
        $user = User::factory();

        $forum = Forum::factory()->for($user, 'forumable')->create();

        $forum->addTags(($tags = Tag::factory()->count(3)->create()->pluck('id')->all()));

        $newTags = Tag::factory()->count(2)->create()->pluck('id')->all();

        $forum->syncTags(array_merge(array_slice($tags, 1), $newTags));

        $this->assertCount(4, $forum->fresh(['tags'])->tags);

        $this->assertContains(last($newTags), $forum->fresh(['tags'])->tags->pluck('id')->all());
    }
}
