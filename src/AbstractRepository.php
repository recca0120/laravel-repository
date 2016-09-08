<?php

namespace Recca0120\Repository;

use Illuminate\Database\Eloquent\Model;
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
    protected $transform;

    /**
     * $perPage.
     *
     * @var int
     */
    public $perPage = 15;

    /**
     * cloneModel.
     *
     * @method cloneModel
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
     * @method match
     *
     * @param \Recca0120\Repository\Criteria|array $criteria
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection
     */
    public function match($criteria)
    {
        $model = $this->cloneModel();
        $class = $this->transform;
        $transform = new $class($model);

        return $transform->push($criteria)->apply();
    }

    /**
     * count.
     *
     * @method count
     *
     * @param \Recca0120\Repository\Criteria|array $criteria
     *
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
     * @method chunk
     *
     * @param \Recca0120\Repository\Criteria|array $criteria
     * @param int                                  $count
     * @param callable                             $callback
     *
     * @return bool
     */
    public function chunk($criteria, $count, callable $callback)
    {
        $model = $this->match($criteria);

        return $model->chunk($count, $callback);
    }
}
