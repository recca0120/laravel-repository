<?php

namespace Recca0120\Repository;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Recca0120\Repository\Tranforms\Collection as CollectionTranform;

class CollectionRepository extends AbstractRepository
{
    /**
     * $model.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $model;

    /**
     * $converter.
     *
     * @var string
     */
    protected $transform = CollectionTranform::class;

    /**
     * __construct.
     *
     * @method __construct
     *
     * @param \Illuminate\Support\Collection $model
     */
    public function __construct(Collection $model)
    {
        $this->model = $model->make()->map(function ($item) {
            return (is_object($item) === false && is_array($item) === true) ? new Fluent($item) : $item;
        });
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
     * @param bool  $forceFill
     *
     * @return mixed
     */
    public function create($data, $forceFill = false)
    {
    }

    /**
     * update.
     *
     * @method update
     *
     * @param array $data
     * @param int   $id
     * @param bool  $forceFill
     *
     * @return mixed
     */
    public function update($data, $id, $forceFill = false)
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
     * factory.
     *
     * @method factory
     *
     * @param array $data
     *
     * @return \Illuminate\Support\Fluent
     */
    public function factory($data = [])
    {
        return new Fluent($data);
    }

    /**
     * first.
     *
     * @method first
     *
     * @param \Recca0120\Repository\Criteria|array $criteria
     *
     * @return mixed
     */
    public function first($criteria = [], $columns = ['*'])
    {
        $model = $this->match($criteria);

        return $model->first();
    }

    /**
     * get.
     *
     * @method get
     *
     * @param \Recca0120\Repository\Criteria|array $criteria
     * @param array                                $orderBy
     * @param int                                  $limit
     * @param int                                  $offset
     *
     * @return \Illuminate\Support\Collection
     */
    public function get($criteria = [], $columns = ['*'], $limit = null, $offset = null)
    {
        $model = $this->match($criteria);

        if (is_null($limit) === false) {
            $model = $model->take($limit);
        }

        if (is_null($offset) === false) {
            $model = $model->skip($offset);
        }

        return $model;
    }

    /**
     * paginate.
     *
     * @method paginate
     *
     * @param mixed  $criteria
     * @param string $perPage
     * @param int    $pageName
     * @param int    $page
     *
     * @return \illuminate\Pagination\AbstractPaginator
     */
    public function paginate($criteria = [], $columns = ['*'], $perPage = null, $pageName = 'page', $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);
        $perPage = $perPage ?: 15;
        $items = $this->get($criteria);
        $total = $items->count();
        $items = $items->forPage($page, $perPage);

        return new LengthAwarePaginator($items, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }
}
