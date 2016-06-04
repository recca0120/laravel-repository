<?php

namespace Recca0120\Repository;

use Illuminate\Database\Eloquent\Model;
use Recca0120\Repository\Contracts\EloquentRepository as EloquentRepositoryContract;
use Recca0120\Repository\Filters\EloquentFilter;

class EloquentRepository implements EloquentRepositoryContract
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function findAll()
    {
        return $this->findBy([]);
    }

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

    public function paginatedAll($perPage = null)
    {
        return $this->paginatedBy([]);
    }

    public function paginatedBy($criteria, $perPage = null)
    {
        $model = $this->matching($criteria);

        return $model->paginate($perPage);
    }

    public function findOneBy($criteria)
    {
        $model = $this->matching($criteria);

        return $model->first();
    }

    public function find($id)
    {
        return $this->cloneModel()->find($id);
    }

    public function create($data)
    {
        return $this->cloneModel()->create($data);
    }

    public function update($data, $id)
    {
        $model = $this->find($id)
            ->fill($data);
        $model->save();

        return $model;
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    public function cloneModel()
    {
        return clone $this->model;
    }

    public function matching($criteria)
    {
        return (new EloquentFilter())->apply($this->cloneModel(), $criteria);
    }
}
