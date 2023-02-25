<?php

namespace Lunacms\Forums\Repositories\Criteria;

interface CriterionInterface
{
    /**
     * Applies given logic to entity.
     *
     * @param $entity
     * @return mixed
     */
    public function apply($entity);
}
