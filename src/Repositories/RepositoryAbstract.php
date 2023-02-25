<?php

namespace Lunacms\Forums\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Lunacms\Forums\Repositories\Contracts\RepositoryInterface;
use Lunacms\Forums\Repositories\Criteria\CriteriaInterface;
use Lunacms\Forums\Repositories\Criteria\CriterionInterface;
use Lunacms\Forums\Repositories\Exceptions\NoEntityDefinedException;

abstract class RepositoryAbstract implements RepositoryInterface, CriteriaInterface
{
    /**
     * A model or resource that repository should be queried against.
     *
     * @return string
     */
    protected $entity;

    /**
     * RepositoryAbstract constructor.
     *
     */
    public function __construct()
    {
        $this->entity = $this->resolveEntity();
    }

    /**
     * Get all records for a given entity.
     *
     * @return mixed
     */
    public function all()
    {
        return $this->entity->get();
    }

    /**
     * Find a record by given "id".
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $model = $this->entity->find($id);

        if (!$model) {
            throw (new ModelNotFoundException)->setModel(
                get_class($this->entity->getModel()), $id
            );
        }

        return $model;
    }

    /**
     * Find records by given "column" value.
     *
     * @param $column
     * @param $value
     * @return mixed
     */
    public function findWhere($column, $value)
    {
        return $this->entity->where($column, $value)->get();
    }

    /**
     * Find the first record with given "column" value.
     *
     * @param $column
     * @param $value
     * @return mixed
     */
    public function findWhereFirst($column, $value)
    {
        $model = $this->entity->where($column, $value)->first();

        if (!$model) {
            throw (new ModelNotFoundException)->setModel(
                get_class($this->entity->getModel())
            );
        }

        return $model;
    }

    /**
     * Paginate records for a given entity.
     *
     * @param int $perPage
     * @return mixed
     */
    public function paginate($perPage = 10)
    {
        return $this->entity->paginate($perPage);
    }

    /**
     * Create a record for a given entity.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->entity->create($data);
    }

    /**
     * Update a record of a given entity.
     *
     * @param       $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data)
    {
        return $this->find($id)->update($data);
    }

    /**
     * Delete a record from an entity.
     *
     * @param  $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    /**
     * Refines a repository's query.
     *
     * @param  array ...$criteria [relationships, scopes, filters]
     * @return \Lunacms\Forums\Repositories\RepositoryAbstract
     */
    public function withCriteria(...$criteria)
    {
        $criteria = Arr::flatten($criteria);

        $criteria = Arr::where($criteria, function ($criterion) {
            return $criterion instanceof CriterionInterface;
        });

        foreach ($criteria as $criterion) {
            $this->entity = $criterion->apply($this->entity);
        }

        return $this;
    }

    /**
     * Resolve's the repository's entity.
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Lunacms\Forums\Repositories\Exceptions\NoEntityDefinedException
     */
    protected function resolveEntity()
    {
        if (!method_exists($this,'entity')) {
            throw new NoEntityDefinedException('No entity defined.');
        }

        return app()->make($this->entity());
    }
}
