<?php

namespace Recca0120\Repository;

use Illuminate\Database\Eloquent\Model;

abstract class EloquentRepository
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
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Find a model by its primary key.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function find($id, $columns = ['*'])
    {
        return $this->newQuery()->find($id, $columns);
    }

    /**
     * Find multiple models by their primary keys.
     *
     * @param  \Illuminate\Contracts\Support\Arrayable|array  $ids
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
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
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
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findOrNew($id, $columns = ['*'])
    {
        return $this->newQuery()->findOrNew($id, $columns);
    }

    /**
     * Get the first record matching the attributes or instantiate it.
     *
     * @param  array  $attributes
     * @param  array  $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function firstOrNew(array $attributes, array $values = [])
    {
        return $this->newQuery()->firstOrNew($attributes, $values);
    }

    /**
     * Get the first record matching the attributes or create it.
     *
     * @param  array  $attributes
     * @param  array  $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function firstOrCreate(array $attributes, array $values = [])
    {
        return $this->newQuery()->firstOrCreate($attributes, $values);
    }

    /**
     * Create or update a record matching the attributes, and fill it with values.
     *
     * @param  array  $attributes
     * @param  array  $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->newQuery()->updateOrCreate($attributes, $values);
    }

    /**
     * Execute the query and get the first result or throw an exception.
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|static
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function firstOrFail($columns = ['*'])
    {
        return $this->newQuery()->firstOrFail($columns);
    }

    /**
     * create.
     *
     * @param  array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Throwable
     */
    public function create($attributes)
    {
        return tap($this->newInstance(), function ($instance) use ($attributes) {
            $instance->fill($attributes)->saveOrFail();
        });
    }

    /**
     * Save a new model and return the instance.
     *
     * @param  array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Throwable
     */
    public function forceCreate($attributes)
    {
        return tap($this->newInstance(), function ($instance) use ($attributes) {
            $instance->forceFill($attributes)->saveOrFail();
        });
    }

    /**
     * update.
     *
     * @param  array $attributes
     * @param  mixed $id
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Throwable
     */
    public function update($attributes, $id)
    {
        return tap($this->findOrFail($id), function ($instance) use ($attributes) {
            $instance->fill($attributes)->saveOrFail();
        });
    }

    /**
     * forceCreate.
     *
     * @param  array $attributes
     * @param  mixed $id
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Throwable
     */
    public function forceUpdate($attributes, $id)
    {
        return tap($this->findOrFail($id), function ($instance) use ($attributes) {
            $instance->forceFill($attributes)->saveOrFail();
        });
    }

    /**
     * delete.
     *
     * @param  mixed $id
     */
    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    /**
     * Force a hard delete on a soft deleted model.
     *
     * This method protects developers from running forceDelete when trait is missing.
     *
     * @param  mixed $id
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
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function newInstance($attributes = [], $exists = false)
    {
        return $this->getModel()->newInstance($attributes, $exists);
    }

    /**
     * Execute the query as a "select" statement.
     *
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @param  array  $columns
     * @return \Illuminate\Support\Collection
     */
    public function get($criteria = [], $columns = ['*'])
    {
        return $this->matching($criteria)->get($columns);
    }

    /**
     * Chunk the results of the query.
     *
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @param  int  $count
     * @param  callable  $callback
     * @return bool
     */
    public function chunk($criteria, $count, callable $callback)
    {
        return $this->matching($criteria)->chunk($count, $callback);
    }

    /**
     * Execute a callback over each item while chunking.
     *
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @param  callable  $callback
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
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|static|null
     */
    public function first($criteria = [], $columns = ['*'])
    {
        return $this->matching($criteria)->first($columns);
    }

    /**
     * Paginate the given query.
     *
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @param  int  $perPage
     * @param  array  $columns
     * @param  string  $pageName
     * @param  int|null  $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws \InvalidArgumentException
     */
    public function paginate($criteria = [], $perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return $this->matching($criteria)->paginate($perPage, $columns, $pageName, $page);
    }

    /**
     * Paginate the given query into a simple paginator.
     *
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @param  int  $perPage
     * @param  array  $columns
     * @param  string  $pageName
     * @param  int|null  $page
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function simplePaginate($criteria = [], $perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return $this->matching($criteria)->simplePaginate($perPage, $columns, $pageName, $page);
    }

    /**
     * Retrieve the "count" result of the query.
     *
     * @param  \Recca0120\Repository\Criteria[] $criteria
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
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @param  string  $column
     * @return mixed
     */
    public function min($criteria, $column)
    {
        return $this->matching($criteria)->min($column);
    }

    /**
     * Retrieve the maximum value of a given column.
     *
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @param  string  $column
     * @return mixed
     */
    public function max($criteria, $column)
    {
        return $this->matching($criteria)->max($column);
    }

    /**
     * Retrieve the sum of the values of a given column.
     *
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @param  string  $column
     * @return mixed
     */
    public function sum($criteria, $column)
    {
        $result = $this->matching($criteria)->sum($column);

        return $result ?: 0;
    }

    /**
     * Retrieve the average of the values of a given column.
     *
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @param  string  $column
     * @return mixed
     */
    public function avg($criteria, $column)
    {
        return $this->matching($criteria)->avg($column);
    }

    /**
     * Alias for the "avg" method.
     *
     * @param  string  $column
     * @return mixed
     */
    public function average($criteria, $column)
    {
        return $this->avg($criteria, $column);
    }

    /**
     * matching.
     *
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function matching($criteria)
    {
        $criteria = is_array($criteria) === false ? [$criteria] : $criteria;

        return array_reduce($criteria, function ($query, $criteria) {
            $criteria->each(function ($method) use ($query) {
                call_user_func_array([$query, $method->name], $method->parameters);
            });

            return $query;
        }, $this->newQuery());
    }


    /**
     * getQuery.
     *
     * @param \Recca0120\Repository\Criteria[] $criteria
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getQuery($criteria = [])
    {
        return $this->matching($criteria)->getQuery();
    }

    /**
     * getModel.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return $this->model instanceof Model
            ? clone $this->model
            : $this->model->getModel();
    }

    /**
     * Get a new query builder for the model's table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery()
    {
        return $this->model instanceof Model
            ? $this->model->newQuery()
            : clone $this->model;
    }
}
