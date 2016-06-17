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
     * find.
     *
     * @method find
     *
     * @param int $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->cloneModel()->find($id);
    }

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
     * findBy.
     *
     * @method findBy
     *
     * @param mixed $criteria
     * @param array $orderBy
     * @param int   $limit
     * @param int   $offset
     *
     * @return \Illuminate\Support\Collection
     */
    public function findBy($criteria, $limit = null, $offset = null)
    {
        $model = $this->matching($criteria);

        if (is_null($limit) === false) {
            $model = $model->take($limit);
        }

        if (is_null($offset) === false) {
            $model = $model->skip($offset);
        }

        return $model->get();
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
    public function paginatedAll($perPage = null)
    {
        return $this->paginatedBy([]);
    }

    /**
     * paginatedBy.
     *
     * @method paginatedBy
     *
     * @param mixed $criteria
     * @param int   $perPage
     *
     * @return |illuminate\Pagination\AbstractPaginator
     */
    public function paginatedBy($criteria, $perPage = null)
    {
        $model = $this->matching($criteria);

        return $model->paginate($perPage);
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
     * findOneBy.
     *
     * @method findOneBy
     *
     * @param mixed $criteria
     *
     * @return mixed
     */
    abstract public function matching($criteria);

    /**
     * create.
     *
     * @method create
     *
     * @param array $data
     *
     * @return mixed
     */
    abstract public function create($data);

    /**
     * update.
     *
     * @method update
     *
     * @param array $data
     * @param int   $id
     *
     * @return mixed
     */
    abstract public function update($data, $id);

    /**
     * delete.
     *
     * @method delete
     *
     * @param int $id
     *
     * @return bool
     */
    abstract public function delete($id);

    /**
     * newInstance.
     *
     * @method newInstance
     *
     * @param array $data
     *
     * @return mixed
     */
    abstract public function newInstance($data = []);
}
