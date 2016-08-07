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
        $model = $this->newInstance();
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
     * newInstance.
     *
     * @method newInstance
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent
     */
    public function newInstance($data = [])
    {
        $model = $this->cloneModel();
        $model = ($model instanceof Model) ? $model : $model->getModel();

        return $model->forceFill($data);
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

        return $model->get();
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
        $model = $this->matching($criteria);

        return $model->paginate($perPage, ['*'], $pageName, $page);
    }
}
