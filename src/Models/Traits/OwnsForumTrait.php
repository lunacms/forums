<?php

namespace Lunacms\Forums\Models\Traits;

use Lunacms\Forums\Forums\Models\Forum;

trait OwnsForumTrait
{
    /**
     * Boot the trait.
     */
    public static function bootOwnsForumTrait()
    {
        //
    }

    /**
     * Get the model's forum.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function forum()
    {
        return $this->morphOne(Forum::class, 'forumable');
    }
}
