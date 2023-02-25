<?php

namespace Tests\Unit;

use Lunacms\Forums\Comments\Models\Comment;
use Lunacms\Forums\Posts\Models\Post;
use Lunacms\Forums\Tests\Models\User;
use Lunacms\Forums\Tests\TestCase;

class CommentTest extends TestCase
{
    public function test_it_has_commentable()
    {
    	$comment = Comment::factory()
    				->for(
		                Post::factory()->for(User::factory(), 'owner'), 'commentable'
		            )
		            ->for(
		                User::factory(), 'owner'
		            )
    				->create();

    	$this->assertInstanceOf(Post::class, $comment->commentable);
    }

    public function test_it_has_owner()
    {
    	$comment = Comment::factory()
    				->for(Post::factory()->for(User::factory(), 'owner'), 'commentable')
    				->for(User::factory(), 'owner')
    				->create();

    	$this->assertInstanceOf(User::class, $comment->owner);
    }
}
