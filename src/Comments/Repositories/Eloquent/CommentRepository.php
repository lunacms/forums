<?php

namespace Lunacms\Forums\Comments\Repositories\Eloquent;

use Lunacms\Forums\Comments\Models\Comment;
use Lunacms\Forums\Repositories\RepositoryAbstract;

class CommentRepository extends RepositoryAbstract
{
    /**
     * Define the repository's entity.
     *
     * @return string
     */
    public function entity()
    {
        return config('forums.models.comments', Comment::class);
    }
}
