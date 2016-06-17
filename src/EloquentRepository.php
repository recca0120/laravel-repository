<?php

namespace Recca0120\Repository;

use Illuminate\Database\Eloquent\Model;
use Recca0120\Repository\Matchers\EloquentMatcher;

class EloquentRepository extends AbstractRepository
{
    /**
     * $model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

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
        return (new EloquentMatcher())->apply($this->cloneModel(), $criteria);
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
}
