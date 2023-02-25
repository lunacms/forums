<?php

namespace Lunacms\Forums\Repositories\Eloquent\Criteria;

use Lunacms\Forums\Repositories\Criteria\CriterionInterface;

class EagerLoad implements CriterionInterface
{
    /**
     * An array of relationships to be eager loaded.
     *
     * @var array
     */
    public $relations;

    /**
     * EagerLoad constructor.
     *
     * @param   array $relations
     * @return  void
     */
    public function __construct(array $relations)
    {
        $this->relations = $relations;
    }

    /**
     * Applies given logic to entity.
     *
     * @param $entity
     * @return mixed
     */
    public function apply($entity)
    {
        return $entity->with($this->relations);
    }
}
