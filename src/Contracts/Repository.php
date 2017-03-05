<?php

namespace Recca0120\Repository\Contracts;

interface Repository
{
    /**
     * match.
     *
     * @param \Recca0120\Repository\Criteria|array $criteria
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection
     */
    public function match($criteria);

    /**
     * cloneModel.
     *
     * @return \Illuminate\Database\Eloquent
     */
    public function cloneModel();

    /**
     * get.
     *
     * @param \Recca0120\Repository\Criteria|array $criteria
     * @param int                                  $limit
     * @param int                                  $offset
     * @return \Illuminate\Support\Collection
     */
    public function get($criteria = [], $columns = ['*'], $limit = null, $offset = null);

    /**
     * paginate.
     *
     * @param mixed  $criteria
     * @param string $perPage
     * @param int    $pageName
     * @param int    $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($criteria = [], $perPage = null, $columns = ['*'], $pageName = 'page', $page = null);

    /**
     * simplePaginate.
     *
     * @param mixed  $criteria
     * @param string $perPage
     * @param int    $pageName
     * @param int    $page
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function simplePaginate($criteria = [], $perPage = null, $columns = ['*'], $pageName = 'page', $page = null);

    /**
     * first.
     *
     * @param \Recca0120\Repository\Criteria|array $criteria
     * @return mixed
     */
    public function first($criteria = [], $columns = ['*']);

    /**
     * find.
     *
     * @param int   $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*']);

    /**
     * count.
     *
     * @param \Recca0120\Repository\Criteria|array $criteria
     * @return int
     */
    public function count($criteria = []);

    /**
     * newInstance.
     *
     * @return \Illuminate\Database\Eloquent
     */
    public function newInstance($attributes = []);

    /**
     * create.
     *
     * @param array $attributes
     * @param bool  $forceFill
     * @return mixed
     */
    public function create($attributes, $forceFill = false);

    /**
     * update.
     *
     * @param array $attributes
     * @param int   $id
     * @param bool  $forceFill
     * @return mixed
     */
    public function update($attributes, $id, $forceFill = false);

    /**
     * delete.
     *
     * @param int $id
     * @return bool
     */
    public function delete($id);

    /**
     * destroy.
     *
     * @param \Recca0120\Repository\Criteria|array $criteria
     * @return int
     */
    public function destroy($criteria = []);
}
