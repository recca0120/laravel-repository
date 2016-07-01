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
        return $this->cloneModel()->find($id);
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
        return $this->cloneModel()->create($data);
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
        $model = $this->find($id)
            ->fill($data);

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
        return $this->cloneModel()
            ->forceFill($data);
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
