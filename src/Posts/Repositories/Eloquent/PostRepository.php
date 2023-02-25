<?php

namespace Lunacms\Forums\Posts\Repositories\Eloquent;

use Lunacms\Forums\Posts\Models\Post;
use Lunacms\Forums\Repositories\RepositoryAbstract;

class PostRepository extends RepositoryAbstract
{
    /**
     * Define the repository's entity.
     *
     * @return string
     */
    public function entity()
    {
        return config('forums.models.posts', Post::class);
    }
}
