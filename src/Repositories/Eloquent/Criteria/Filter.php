<?php

namespace Lunacms\Forums\Repositories\Eloquent\Criteria;

use Illuminate\Http\Request;
use Lunacms\Forums\Repositories\Criteria\CriterionInterface;

class Filter implements CriterionInterface
{
    /**
     * Instance of request.
     *
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * Filter constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Applies given logic to entity.
     *
     * @param $entity
     * @return mixed
     */
    public function apply($entity)
    {
        return $entity->filter($this->request);
    }
}
