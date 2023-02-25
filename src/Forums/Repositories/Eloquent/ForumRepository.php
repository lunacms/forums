<?php

namespace Lunacms\Forums\Forums\Repositories\Eloquent;

use Lunacms\Forums\Forums\Models\Forum;
use Lunacms\Forums\Repositories\RepositoryAbstract;

class ForumRepository extends RepositoryAbstract
{
    /**
     * Define the repository's entity.
     *
     * @return string
     */
    public function entity()
    {
        return config('forums.models.forums', Forum::class);
    }
}
