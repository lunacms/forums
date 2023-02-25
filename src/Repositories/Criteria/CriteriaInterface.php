<?php

namespace Lunacms\Forums\Repositories\Criteria;

interface CriteriaInterface
{
    /**
     * Refines a repository's query.
     *
     * @param array ...$criteria [relationships, scopes, filters]
     * @return mixed
     */
    public function withCriteria(...$criteria);
}
