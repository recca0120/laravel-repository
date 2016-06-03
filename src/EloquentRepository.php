<?php

namespace Recca0120\Repository;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Expression as QueryExpression;
use Recca0120\Repository\Contracts\EloquentRepository as EloquentRepositoryContract;
use Recca0120\Repository\Criteria\Expression as CriteriaExpression;

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
        $model = $this->applyCriteria($this->cloneModel(), $criteria);

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
        $model = $this->applyCriteria($this->cloneModel(), $criteria);

        return $model->paginate($perPage);
    }

    public function findOneBy($criteria)
    {
        $model = $this->applyCriteria($this->cloneModel(), $criteria);

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

    protected function applyCriteria($model, $criteria)
    {
        if (empty($criteria) === true) {
            return $model;
        }

        $bindings = $criteria->getBindings();
        foreach ($bindings as $key => $parameters) {
            if (count($parameters) === 0) {
                continue;
            }
            $method = 'applyCriteria'.ucfirst($key);
            if (method_exists($this, $method)) {
                $model = call_user_func_array([$this, $method], [$model, $parameters]);
            } else {
                $model = $this->doApplyCriteria($model, $parameters);
            }
        }

        return $model;
    }

    protected function doApplyCriteria($model, $bindings)
    {
        foreach ($bindings as $binding) {
            $method = $binding['method'];
            $parameters = array_map(function ($parameter) use ($method) {
                if ($parameter instanceof Closure) {
                    $criteria = call_user_func($parameter, new Criteria());

                    return function ($query) use ($criteria) {
                        return $this->applyCriteria($query, $criteria);
                    };
                }

                if ($parameter instanceof CriteriaExpression) {
                    return new QueryExpression($parameter->getValue());
                }

                return $parameter;
            }, $binding['parameters']);
            $model = call_user_func_array([$model, $method], $parameters);
        }

        return $model;
    }
}
