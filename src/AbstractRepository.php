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
        return $this->paginatedBy([], $perPage = null, $pageName = 'page', $page = null);
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
}
