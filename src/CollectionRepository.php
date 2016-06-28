<?php

namespace Recca0120\Repository;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Recca0120\Repository\Matchers\CollectionMatcher;

class CollectionRepository extends AbstractRepository
{
    /**
     * $model.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $model;

    /**
     * __construct.
     *
     * @method __construct
     *
     * @param \Illuminate\Support\Collection $model
     */
    public function __construct(Collection $model)
    {
        $this->model = $model->load();
    }

    /**
     * matching.
     *
     * @method matching
     *
     * @param mixed $criteria
     *
     * @return mixed
     */
    public function matching($criteria)
    {
        return (new CollectionMatcher())->apply($this->cloneModel(), $criteria);
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
        return $this->cloneModel()->where('id', $id)->first();
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
    }

    /**
     * newInstance.
     *
     * @method newInstance
     *
     * @param array $data
     *
     * @return \Illuminate\Support\Fluent
     */
    public function newInstance($data = [])
    {
        return new Fluent($data);
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

        return $model;
    }

    /**
     * paginatedBy.
     *
     * @method paginatedBy
     *
     * @param mixed  $criteria
     * @param string $perPage
     * @param int    $pageName
     * @param int    $page
     *
     * @return |illuminate\Pagination\AbstractPaginator
     */
    public function paginatedBy($criteria, $perPage = null, $pageName = 'page', $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);
        $perPage = $perPage ?: 15;
        $items = $this->findBy($criteria);
        $total = $items->count();
        $items = $items->forPage($page, $perPage);

        return new LengthAwarePaginator($items, $total, $perPage, $page, [
            'path'     => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }
}
