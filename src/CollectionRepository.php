<?php

namespace Recca0120\Repository;

use Illuminate\Support\Fluent;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Recca0120\Repository\Compilers\CollectionCompiler;

class CollectionRepository extends AbstractRepository
{
    /**
     * $primaryKey.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * $converter.
     *
     * @var string
     */
    protected $compiler = CollectionCompiler::class;

    /**
     * __construct.
     *
     * @param \Illuminate\Support\Collection $model
     */
    public function __construct(Collection $model)
    {
        $this->model = $model->make()->map(function ($item) {
            return (is_object($item) === false && is_array($item) === true) ? new Fluent($item) : $item;
        })->keyBy($this->primaryKey);
    }

    /**
     * get.
     *
     * @param \Recca0120\Repository\Criteria|array $criteria
     * @param int                                  $limit
     * @param int                                  $offset
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

        return $model->keyBy($this->primaryKey);
    }

    /**
     * paginate.
     *
     * @param mixed  $criteria
     * @param string $perPage
     * @param int    $pageName
     * @param int    $page
     * @return \illuminate\Pagination\AbstractPaginator
     */
    public function paginate($criteria = [], $perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);
        $perPage = $perPage ?: $this->perPage;
        $items = $this->get($criteria, $columns);
        $total = $items->count();
        $items = $items->forPage($page, $perPage);

        return new LengthAwarePaginator($items, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }

    /**
     * simplePaginate.
     *
     * @param mixed  $criteria
     * @param string $perPage
     * @param int    $pageName
     * @param int    $page
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function simplePaginate($criteria = [], $perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);
        $perPage = $perPage ?: $this->perPage;
        $items = $this->get($criteria, $columns);
        $items = $items->forPage($page, $perPage);

        return new Paginator($items, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }

    /**
     * first.
     *
     * @param \Recca0120\Repository\Criteria|array $criteria
     * @return mixed
     */
    public function first($criteria = [], $columns = ['*'])
    {
        $model = $this->match($criteria);

        return $model->first();
    }

    /**
     * find.
     *
     * @param int $id
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model->get($id);
    }

    /**
     * newInstance.
     *
     * @param array $attributes
     * @return \Illuminate\Support\Fluent
     */
    public function newInstance($attributes = [])
    {
        return new Fluent($attributes);
    }

    /**
     * create.
     *
     * @param array $attributes
     * @param bool  $forceFill
     * @return mixed
     */
    public function create($attributes, $forceFill = false)
    {
        $model = $this->newInstance($attributes);
        $this->model->push($model);

        return $model;
    }

    /**
     * update.
     *
     * @param array $attributes
     * @param int   $id
     * @param bool  $forceFill
     * @return mixed
     */
    public function update($attributes, $id, $forceFill = false)
    {
        $model = $this->find($id);
        foreach ($attributes as $key => $value) {
            $model->{$key} = $value;
        }
        $this->model->put($id, $model);

        return $model;
    }

    /**
     * delete.
     *
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $this->model->forget($id);

        return $this->model->has($id);
    }

    /**
     * destroy.
     *
     * @param \Recca0120\Repository\Criteria|array $criteria
     * @return int
     */
    public function destroy($criteria = [])
    {
        // $items = $this->match($criteria)->keys()->toArray();
        // $count = $this->count();
        //
        // $this->model = $this->model->filter(function ($item) use ($items) {
        //     return in_array($item->{$this->primaryKey}, $items, true) === false;
        // });
        //
        // return count($items);
    }
}
