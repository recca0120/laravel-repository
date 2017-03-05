<?php

namespace Recca0120\Repository;

use Recca0120\Repository\Contracts\Repository as RepositoryContract;

abstract class AbstractRepository implements RepositoryContract
{
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
     * $perPage.
     *
     * @var int
     */
    public $perPage = 15;

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
     * @param \Recca0120\Repository\Criteria|array $criteria
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
     * @param \Recca0120\Repository\Criteria|array $criteria
     * @return int
     */
    public function count($criteria = [])
    {
        $model = $this->match($criteria);

        return $model->count();
    }

    /**
     * chunk.
     *
     * @param \Recca0120\Repository\Criteria|array $criteria
     * @param int $count
     * @param callable $callback
     * @return \Illuminate\Support\Collection
     */
    public function chunk($criteria, $count, callable $callback)
    {
        $model = $this->match($criteria);

        return $model->chunk($count, $callback);
    }
}
