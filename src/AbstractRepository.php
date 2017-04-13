<?php

namespace Recca0120\Repository;

use Recca0120\Repository\Contracts\Repository as RepositoryContract;

abstract class AbstractRepository implements RepositoryContract
{
    /**
     * $perPage.
     *
     * @var int
     */
    public $perPage = 15;

    /**
     * $model.
     *
     * @var mixed
     */
    protected $model;

    /**
     * $transform.
     *
     * @var string
     */
    protected $compiler;

    /**
     * cloneModel.
     *
     * @return \Illuminate\Database\Eloquent
     */
    public function cloneModel()
    {
        return clone $this->model;
    }

    /**
     * match.
     *
     * @param Criteria|array $criteria
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function match($criteria)
    {
        $model = $this->cloneModel();
        $class = $this->compiler;
        $compiler = new $class($model);

        return $compiler->push($criteria)->apply();
    }

    /**
     * count.
     *
     * @param Criteria|array $criteria
     * @return int
     */
    public function count($criteria = [])
    {
        $model = $this->match($criteria);

        return $model->count();
    }
}
