<?php

namespace Lunacms\Forums\Models\Traits;

use Lunacms\Forums\Comments\Models\Comment;

/**
 * Handles comment operations for model.
 */
trait CanCommentTrait
{
    /**
     * Boot the trait.
     */
    public static function bootCanCommentTrait()
    {
        //
    }

    /**
     * Get all of the user's comments.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'owner');
    }
}
