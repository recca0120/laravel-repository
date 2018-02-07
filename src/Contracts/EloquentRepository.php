<?php

namespace Recca0120\Repository\Contracts;

interface EloquentRepository
{
    /**
     * Find a model by its primary key.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function find($id, $columns = ['*']);

    /**
     * Find multiple models by their primary keys.
     *
     * @param  \Illuminate\Contracts\Support\Arrayable|array  $ids
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findMany($ids, $columns = ['*']);

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail($id, $columns = ['*']);

    /**
     * Find a model by its primary key or return fresh model instance.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findOrNew($id, $columns = ['*']);

    /**
     * Get the first record matching the attributes or instantiate it.
     *
     * @param  array  $attributes
     * @param  array  $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function firstOrNew(array $attributes, array $values = []);

    /**
     * Get the first record matching the attributes or create it.
     *
     * @param  array  $attributes
     * @param  array  $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function firstOrCreate(array $attributes, array $values = []);

    /**
     * Create or update a record matching the attributes, and fill it with values.
     *
     * @param  array  $attributes
     * @param  array  $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreate(array $attributes, array $values = []);

    /**
     * Execute the query and get the first result or throw an exception.
     *
     * @param  array  $columns
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @return \Illuminate\Database\Eloquent\Model|static
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function firstOrFail($criteria = [], $columns = ['*']);

    /**
     * create.
     *
     * @param  array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Throwable
     */
    public function create($attributes);

    /**
     * Save a new model and return the instance.
     *
     * @param  array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Throwable
     */
    public function forceCreate($attributes);

    /**
     * update.
     *
     * @param  array $attributes
     * @param  mixed $id
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Throwable
     */
    public function update($id, $attributes);

    /**
     * forceCreate.
     *
     * @param  array $attributes
     * @param  mixed $id
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Throwable
     */
    public function forceUpdate($id, $attributes);

    /**
     * delete.
     *
     * @param  mixed $id
     */
    public function delete($id);

    /**
     * Force a hard delete on a soft deleted model.
     *
     * This method protects developers from running forceDelete when trait is missing.
     *
     * @param  mixed $id
     * @return bool|null
     */
    public function forceDelete($id);

    /**
     * Create a new model instance that is existing.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function newInstance($attributes = [], $exists = false);

    /**
     * Execute the query as a "select" statement.
     *
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @param  array  $columns
     * @return \Illuminate\Support\Collection
     */
    public function get($criteria = [], $columns = ['*']);

    /**
     * Chunk the results of the query.
     *
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @param  int  $count
     * @param  callable  $callback
     * @return bool
     */
    public function chunk($criteria, $count, callable $callback);

    /**
     * Execute a callback over each item while chunking.
     *
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @param  callable  $callback
     * @param  int  $count
     * @return bool
     */
    public function each($criteria, callable $callback, $count = 1000);

    /**
     * Execute the query and get the first result.
     *
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|static|null
     */
    public function first($criteria = [], $columns = ['*']);

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
    public function paginate($criteria = [], $perPage = null, $columns = ['*'], $pageName = 'page', $page = null);

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
    public function simplePaginate($criteria = [], $perPage = null, $columns = ['*'], $pageName = 'page', $page = null);

    /**
     * Retrieve the "count" result of the query.
     *
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @param  string  $columns
     * @return int
     */
    public function count($criteria = [], $columns = '*');

    /**
     * Retrieve the minimum value of a given column.
     *
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @param  string  $column
     * @return mixed
     */
    public function min($criteria, $column);

    /**
     * Retrieve the maximum value of a given column.
     *
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @param  string  $column
     * @return mixed
     */
    public function max($criteria, $column);

    /**
     * Retrieve the sum of the values of a given column.
     *
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @param  string  $column
     * @return mixed
     */
    public function sum($criteria, $column);

    /**
     * Retrieve the average of the values of a given column.
     *
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @param  string  $column
     * @return mixed
     */
    public function avg($criteria, $column);

    /**
     * Alias for the "avg" method.
     *
     * @param  string  $column
     * @return mixed
     */
    public function average($criteria, $column);

    /**
     * matching.
     *
     * @param  \Recca0120\Repository\Criteria[] $criteria
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function matching($criteria);

    /**
     * getQuery.
     *
     * @param \Recca0120\Repository\Criteria[] $criteria
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getQuery($criteria = []);

    /**
     * getModel.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel();

    /**
     * Get a new query builder for the model's table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery();
}
