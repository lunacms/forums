<?php

namespace Lunacms\Forums\Tags\Repositories\Eloquent;

use Lunacms\Forums\Tags\Models\Tag;
use Lunacms\Forums\Repositories\RepositoryAbstract;

class TagRepository extends RepositoryAbstract
{
    /**
     * Define the repository's entity.
     *
     * @return string
     */
    public function entity()
    {
        return config('forums.models.tags', Tag::class);
    }
}
