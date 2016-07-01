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
     * findAll.
     *
     * @method findAll
     *
     * @return \Illuminate\Support\Collection
     */
    public function findAll()
    {
        return $this->findBy([]);
    }

    /**
     * findOneBy.
     *
     * @method findOneBy
     *
     * @param mixed $criteria
     *
     * @return mixed
     */
    public function findOneBy($criteria)
    {
        $model = $this->matching($criteria);

        return $model->first();
    }

    /**
     * paginatedAll.
     *
     * @method paginatedAll
     *
     * @param int $perPage
     *
     * @return |illuminate\Pagination\AbstractPaginator
     */
    public function paginatedAll($perPage = null, $pageName = 'page', $page = null)
    {
        return $this->paginatedBy([], $perPage, $pageName, $page);
    }

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
     * matching.
     *
     * @method matching
     *
     * @param mixed $criteria
     *
     * @return \Illuminate\Database\Eloquent\Model | \Illuminate\Support\Collection
     */
    public function matching($criteria)
    {
        $model = $this->cloneModel();
        $class = $this->transform;
        $transform = new $class($this->cloneModel());

        $items = is_array($criteria) ? $criteria : [$criteria];
        foreach ($items as $key => $value) {
            if (($value instanceof Criteria) === true) {
                $model = $transform->push($value);
            } else {
                $value = is_array($value) ? $value : [$key, $value];
                $model = $transform->push(new Criteria([$value]));
            }
        }

        return $transform->apply();
    }
}
