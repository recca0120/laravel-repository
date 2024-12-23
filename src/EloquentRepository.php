<?php

namespace Recca0120\Repository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Recca0120\Repository\Contracts\EloquentRepository as EloquentRepositoryContract;
use Throwable;

abstract class EloquentRepository implements EloquentRepositoryContract
{
    /**
     * $model.
     *
     * @var Model|Builder
     */
    protected $model;

    /**
     * __construct.
     *
     * @param  Model|Builder  $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Find a model by its primary key.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return Model
     */
    public function find($id, $columns = ['*'])
    {
        return $this->newQuery()->find($id, $columns);
    }

    /**
     * Find multiple models by their primary keys.
     *
     * @param  Arrayable|array  $ids
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findMany($ids, $columns = ['*'])
    {
        return $this->newQuery()->findMany($ids, $columns);
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return Model
     *
     * @throws ModelNotFoundException
     */
    public function findOrFail($id, $columns = ['*'])
    {
        return $this->newQuery()->findOrFail($id, $columns);
    }

    /**
     * Find a model by its primary key or return fresh model instance.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return Model
     */
    public function findOrNew($id, $columns = ['*'])
    {
        return $this->newQuery()->findOrNew($id, $columns);
    }

    /**
     * Get the first record matching the attributes or instantiate it.
     *
     * @return Model
     */
    public function firstOrNew(array $attributes, array $values = [])
    {
        return $this->newQuery()->firstOrNew($attributes, $values);
    }

    /**
     * Get the first record matching the attributes or create it.
     *
     * @return Model
     */
    public function firstOrCreate(array $attributes, array $values = [])
    {
        return $this->newQuery()->firstOrCreate($attributes, $values);
    }

    /**
     * Create or update a record matching the attributes, and fill it with values.
     *
     * @return Model
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->newQuery()->updateOrCreate($attributes, $values);
    }

    /**
     * Execute the query and get the first result or throw an exception.
     *
     * @param  Criteria[]  $criteria
     * @param  array  $columns
     * @return Model
     *
     * @throws ModelNotFoundException
     */
    public function firstOrFail($criteria = [], $columns = ['*'])
    {
        return $this->matching($criteria)->firstOrFail($columns);
    }

    /**
     * create.
     *
     * @param  array  $attributes
     * @return Model
     *
     * @throws Throwable
     */
    public function create($attributes)
    {
        return $this->newQuery()->create($attributes);
    }

    /**
     * Save a new model and return the instance.
     *
     * @param  array  $attributes
     * @return Model
     *
     * @throws Throwable
     */
    public function forceCreate($attributes)
    {
        return $this->newQuery()->forceCreate($attributes);
    }

    /**
     * update.
     *
     * @param  array  $attributes
     * @param  mixed  $id
     * @return Model
     *
     * @throws Throwable
     */
    public function update($id, $attributes)
    {
        return tap($this->findOrFail($id), static function ($instance) use ($attributes) {
            $instance->fill($attributes)->saveOrFail();
        });
    }

    /**
     * forceCreate.
     *
     * @param  array  $attributes
     * @param  mixed  $id
     * @return Model
     *
     * @throws Throwable
     */
    public function forceUpdate($id, $attributes)
    {
        return tap($this->findOrFail($id), static function ($instance) use ($attributes) {
            $instance->forceFill($attributes)->saveOrFail();
        });
    }

    /**
     * delete.
     *
     * @param  mixed  $id
     */
    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    /**
     * Restore a soft-deleted model instance.
     *
     * @param  mixed  $id
     * @return bool|null
     */
    public function restore($id)
    {
        return $this->newQuery()->where($this->getModel()->getKeyName(), $id)->restore();
    }

    /**
     * Force a hard delete on a soft deleted model.
     *
     * This method protects developers from running forceDelete when trait is missing.
     *
     * @param  mixed  $id
     * @return bool|null
     */
    public function forceDelete($id)
    {
        return $this->findOrFail($id)->forceDelete();
    }

    /**
     * Create a new model instance that is existing.
     *
     * @param  array  $attributes
     * @return Model
     */
    public function newInstance($attributes = [], $exists = false)
    {
        return $this->getModel()->newInstance($attributes, $exists);
    }

    /**
     * Execute the query as a "select" statement.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  array  $columns
     * @return Collection
     */
    public function get($criteria = [], $columns = ['*'])
    {
        return $this->matching($criteria)->get($columns);
    }

    /**
     * Chunk the results of the query.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  int  $count
     * @return bool
     */
    public function chunk($criteria, $count, callable $callback)
    {
        return $this->matching($criteria)->chunk($count, $callback);
    }

    /**
     * Execute a callback over each item while chunking.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  int  $count
     * @return bool
     */
    public function each($criteria, callable $callback, $count = 1000)
    {
        return $this->matching($criteria)->each($callback, $count);
    }

    /**
     * Execute the query and get the first result.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  array  $columns
     * @return Model|null
     */
    public function first($criteria = [], $columns = ['*'])
    {
        return $this->matching($criteria)->first($columns);
    }

    /**
     * Paginate the given query.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  int  $perPage
     * @param  array  $columns
     * @param  string  $pageName
     * @param  int|null  $page
     * @return LengthAwarePaginator
     *
     * @throws InvalidArgumentException
     */
    public function paginate($criteria = [], $perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return $this->matching($criteria)->paginate($perPage, $columns, $pageName, $page);
    }

    /**
     * Paginate the given query into a simple paginator.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  int  $perPage
     * @param  array  $columns
     * @param  string  $pageName
     * @param  int|null  $page
     * @return Paginator
     */
    public function simplePaginate($criteria = [], $perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return $this->matching($criteria)->simplePaginate($perPage, $columns, $pageName, $page);
    }

    /**
     * Retrieve the "count" result of the query.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  string  $columns
     * @return int
     */
    public function count($criteria = [], $columns = '*')
    {
        return (int) $this->matching($criteria)->count($columns);
    }

    /**
     * Retrieve the minimum value of a given column.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  string  $column
     * @return float|int
     */
    public function min($criteria, $column)
    {
        return $this->matching($criteria)->min($column);
    }

    /**
     * Retrieve the maximum value of a given column.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  string  $column
     * @return float|int
     */
    public function max($criteria, $column)
    {
        return $this->matching($criteria)->max($column);
    }

    /**
     * Retrieve the sum of the values of a given column.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  string  $column
     * @return float|int
     */
    public function sum($criteria, $column)
    {
        $result = $this->matching($criteria)->sum($column);

        return $result ?: 0;
    }

    /**
     * Retrieve the average of the values of a given column.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  string  $column
     * @return float|int
     */
    public function avg($criteria, $column)
    {
        return $this->matching($criteria)->avg($column);
    }

    /**
     * Alias for the "avg" method.
     *
     * @param  string  $column
     * @return float|int
     */
    public function average($criteria, $column)
    {
        return $this->avg($criteria, $column);
    }

    /**
     * matching.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @return Builder
     */
    public function matching($criteria)
    {
        $criteria = is_array($criteria) === false ? [$criteria] : $criteria;

        return array_reduce($criteria, static function ($query, $criteria) {
            $criteria->each(static function ($method) use ($query) {
                call_user_func_array([$query, $method->name], $method->parameters);
            });

            return $query;
        }, $this->newQuery());
    }

    /**
     * getQuery.
     *
     * @param  Criteria[]  $criteria
     * @return QueryBuilder
     */
    public function getQuery($criteria = [])
    {
        return $this->matching($criteria)->getQuery();
    }

    /**
     * getModel.
     *
     * @return Model
     */
    public function getModel()
    {
        return $this->model instanceof Model ? clone $this->model : $this->model->getModel();
    }

    /**
     * Get a new query builder for the model's table.
     *
     * @return Builder
     */
    public function newQuery()
    {
        return $this->model instanceof Model ? $this->model->newQuery() : clone $this->model;
    }
}
