<?php

namespace Recca0120\Repository;

use Illuminate\Database\Eloquent\Model;

abstract class EloquentRepository
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
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * newInstance.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function newInstance($attributes = [])
    {
        $model = $this->cloneModel();

        return $model->forceFill($attributes);
    }

    /**
     * create.
     *
     * @param  array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($attributes)
    {
        $model = $this->cloneModel();

        return $this->model->create($attributes);
    }

    /**
     * update.
     *
     * @param  mixed $id
     * @param  array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($id, $attributes)
    {
        $model = $this->cloneModel();

        return $this->model->update($attributes);
    }

    /**
     * cloneModel.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function cloneModel() {
        return clone $this->model;
    }
}
