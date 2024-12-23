<?php

namespace Recca0120\Repository\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;
use Recca0120\Repository\Criteria;
use Throwable;

interface EloquentRepository
{
    /**
     * Find a model by its primary key.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return Model|Collection|static[]|static|null
     */
    public function find($id, $columns = ['*']);

    /**
     * Find multiple models by their primary keys.
     *
     * @param  Arrayable|array  $ids
     * @param  array  $columns
     * @return Collection
     */
    public function findMany($ids, $columns = ['*']);

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return Model|Collection
     *
     * @throws ModelNotFoundException
     */
    public function findOrFail($id, $columns = ['*']);

    /**
     * Find a model by its primary key or return fresh model instance.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return Model
     */
    public function findOrNew($id, $columns = ['*']);

    /**
     * Get the first record matching the attributes or instantiate it.
     *
     * @return Model
     */
    public function firstOrNew(array $attributes, array $values = []);

    /**
     * Get the first record matching the attributes or create it.
     *
     * @return Model
     */
    public function firstOrCreate(array $attributes, array $values = []);

    /**
     * Create or update a record matching the attributes, and fill it with values.
     *
     * @return Model
     */
    public function updateOrCreate(array $attributes, array $values = []);

    /**
     * Execute the query and get the first result or throw an exception.
     *
     * @param  array  $columns
     * @param  Criteria[]|Criteria  $criteria
     * @return Model|static
     *
     * @throws ModelNotFoundException
     */
    public function firstOrFail($criteria = [], $columns = ['*']);

    /**
     * create.
     *
     * @param  array  $attributes
     * @return Model
     *
     * @throws Throwable
     */
    public function create($attributes);

    /**
     * Save a new model and return the instance.
     *
     * @param  array  $attributes
     * @return Model
     *
     * @throws Throwable
     */
    public function forceCreate($attributes);

    /**
     * update.
     *
     * @param  array  $attributes
     * @param  mixed  $id
     * @return Model
     *
     * @throws Throwable
     */
    public function update($id, $attributes);

    /**
     * forceCreate.
     *
     * @param  array  $attributes
     * @param  mixed  $id
     * @return Model
     *
     * @throws Throwable
     */
    public function forceUpdate($id, $attributes);

    /**
     * delete.
     *
     * @param  mixed  $id
     */
    public function delete($id);

    /**
     * Force a hard delete on a soft deleted model.
     *
     * This method protects developers from running forceDelete when trait is missing.
     *
     * @param  mixed  $id
     * @return bool|null
     */
    public function forceDelete($id);

    /**
     * Create a new model instance that is existing.
     *
     * @param  array  $attributes
     * @return Model
     */
    public function newInstance($attributes = [], $exists = false);

    /**
     * Execute the query as a "select" statement.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  array  $columns
     * @return \Illuminate\Support\Collection
     */
    public function get($criteria = [], $columns = ['*']);

    /**
     * Chunk the results of the query.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  int  $count
     * @return bool
     */
    public function chunk($criteria, $count, callable $callback);

    /**
     * Execute a callback over each item while chunking.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  int  $count
     * @return bool
     */
    public function each($criteria, callable $callback, $count = 1000);

    /**
     * Execute the query and get the first result.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  array  $columns
     * @return Model|static|null
     */
    public function first($criteria = [], $columns = ['*']);

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
    public function paginate($criteria = [], $perPage = null, $columns = ['*'], $pageName = 'page', $page = null);

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
    public function simplePaginate($criteria = [], $perPage = null, $columns = ['*'], $pageName = 'page', $page = null);

    /**
     * Retrieve the "count" result of the query.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  string  $columns
     * @return int
     */
    public function count($criteria = [], $columns = '*');

    /**
     * Retrieve the minimum value of a given column.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  string  $column
     * @return mixed
     */
    public function min($criteria, $column);

    /**
     * Retrieve the maximum value of a given column.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  string  $column
     * @return mixed
     */
    public function max($criteria, $column);

    /**
     * Retrieve the sum of the values of a given column.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  string  $column
     * @return mixed
     */
    public function sum($criteria, $column);

    /**
     * Retrieve the average of the values of a given column.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  string  $column
     * @return mixed
     */
    public function avg($criteria, $column);

    /**
     * Alias for the "avg" method.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @param  string  $column
     * @return mixed
     */
    public function average($criteria, $column);

    /**
     * matching.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @return Builder
     */
    public function matching($criteria);

    /**
     * getQuery.
     *
     * @param  Criteria[]|Criteria  $criteria
     * @return Builder
     */
    public function getQuery($criteria = []);

    /**
     * getModel.
     *
     * @return Model
     */
    public function getModel();

    /**
     * Get a new query builder for the model's table.
     *
     * @return Builder
     */
    public function newQuery();
}
