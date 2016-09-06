<?php

namespace Recca0120\Repository;

use Illuminate\Database\Eloquent\Model;
use Recca0120\Repository\Tranforms\Eloquent as EloquentTranform;

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
    protected $transform = EloquentTranform::class;

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
    public function find($id)
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
     * @param array $data
     * @param bool  $forceFill
     *
     * @return mixed
     */
    public function create($data, $forceFill = false)
    {
        $model = $this->factory();
        $model = ($forceFill === false) ? $model->fill($data) : $model->forceFill($data);
        $model->save();

        return $model;
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
        $model = $this->find($id);
        $model = ($forceFill === false) ? $model->fill($data) : $model->forceFill($data);
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
     * factory.
     *
     * @method factory
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent
     */
    public function factory($data = [])
    {
        $model = $this->cloneModel();
        $model = ($model instanceof Model) ? $model : $model->getModel();

        return $model->forceFill($data);
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
     * @return \illuminate\Pagination\AbstractPaginator
     */
    public function paginate($criteria = [], $columns = ['*'], $perPage = null, $pageName = 'page', $page = null)
    {
        $model = $this->match($criteria);

        return $model->paginate($perPage, $columns, $pageName, $page);
    }
}
