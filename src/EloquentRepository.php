<?php

namespace Recca0120\Repository;

use Illuminate\Database\Eloquent\Model;
use Recca0120\Repository\Compilers\EloquentCompiler;
use Recca0120\Repository\Core\AbstractRepository;

class EloquentRepository extends AbstractRepository
{
    /**
     * $model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * $converter.
     *
     * @var string
     */
    protected $compiler = EloquentCompiler::class;

    /**
     * __construct.
     *
     * @method __construct
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
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
    public function find($id, $columns = ['*'])
    {
        $model = $this->cloneModel();
        $model = ($model instanceof Model) ? $model : $model->getModel();

        return $model->find($id);
    }

    /**
     * create.
     *
     * @method create
     *
     * @param array $attributes
     * @param bool  $forceFill
     *
     * @return mixed
     */
    public function create($attributes, $forceFill = false)
    {
        $model = $this->newInstance();
        $model = ($forceFill === false) ? $model->fill($attributes) : $model->forceFill($attributes);
        $model->save();

        return $model;
    }

    /**
     * update.
     *
     * @method update
     *
     * @param array $attributes
     * @param int   $id
     * @param bool  $forceFill
     *
     * @return mixed
     */
    public function update($attributes, $id, $forceFill = false)
    {
        $model = $this->find($id);
        $model = ($forceFill === false) ? $model->fill($attributes) : $model->forceFill($attributes);
        $model->save();

        return $model;
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
        return $this->find($id)->delete();
    }

    /**
     * newInstance.
     *
     * @method newInstance
     *
     * @param array $attributes
     *
     * @return \Illuminate\Database\Eloquent
     */
    public function newInstance($attributes = [])
    {
        $model = $this->cloneModel();
        $model = ($model instanceof Model) ? $model : $model->getModel();

        return $model->forceFill($attributes);
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

        return $model->first($columns);
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

        return $model->get($columns);
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
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($criteria = [], $perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $model = $this->match($criteria);
        $perPage = $perPage ?: $this->perPage;

        return $model->paginate($perPage, $columns, $pageName, $page);
    }

    /**
     * simplePaginate.
     *
     * @method simplePaginate
     *
     * @param mixed  $criteria
     * @param string $perPage
     * @param int    $pageName
     * @param int    $page
     *
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function simplePaginate($criteria = [], $perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $model = $this->match($criteria);
        $perPage = $perPage ?: $this->perPage;

        return $model->simplePaginate($perPage, $columns, $pageName, $page);
    }
}
