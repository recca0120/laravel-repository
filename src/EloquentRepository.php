<?php

namespace Recca0120\Repository;

use Illuminate\Database\Eloquent\Model;
use Recca0120\Repository\Contracts\EloquentRepository as EloquentRepositoryContract;
use Recca0120\Repository\Matchers\EloquentMatcher;

class EloquentRepository implements EloquentRepositoryContract
{
    /**
     * $model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * __construct.
     *
     * @method __construct
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

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
     * findOneBy.
     *
     * @method findOneBy
     *
     * @param mixed $criteria
     *
     * @return mixed
     */
    public function matching($criteria)
    {
        return (new EloquentMatcher())->apply($this->cloneModel(), $criteria);
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
     * @param int $perPage
     *
     * @return |illuminate\Pagination\AbstractPaginator
     */
    public function paginatedBy($criteria, $perPage = null)
    {
        $model = $this->matching($criteria);

        return $model->paginate($perPage);
    }

    /**
     * create.
     *
     * @method create
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create($data)
    {
        return $this->cloneModel()->create($data);
    }

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
    public function update($data, $id)
    {
        $model = $this->find($id)
            ->fill($data);

        $model->save();

        return $model;
    }

    /**
     * delete.
     *
     * @method delete
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete($id)
    {
        return $this->find($id)->delete();
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
     * newInstance.
     *
     * @method newInstance
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent
     */
    public function newInstance($data = [])
    {
        return $this->cloneModel()
            ->forceFill($data);
    }
}
