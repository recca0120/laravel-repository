<?php

namespace Recca0120\Repository\Concerns;

use Recca0120\Repository\Method;
use Illuminate\Database\Eloquent\Model;

trait EloquentBuildsQueries
{
    /**
     * Add a where clause on the primary key to the query.
     *
     * @param  mixed  $id
     * @return $this
     */
    public function whereKey($id)
    {
        $this->methods[] = new Method(__FUNCTION__, [$id]);

        return $this;
    }

    /**
     * Add a where clause on the primary key to the query.
     *
     * @param  mixed  $id
     * @return $this
     */
    public function whereKeyNot($id)
    {
        $this->methods[] = new Method(__FUNCTION__, [$id]);

        return $this;
    }

    /**
     * Set the relationships that should be eager loaded.
     *
     * @param  mixed  $relations
     * @return $this
     */
    public function with($relations)
    {
        $this->methods[] = new Method(__FUNCTION__, [$relations]);

        return $this;
    }

    /**
     * Prevent the specified relations from being eager loaded.
     *
     * @param  mixed  $relations
     * @return $this
     */
    public function without($relations)
    {
        $this->methods[] = new Method(__FUNCTION__, [$relations]);

        return $this;
    }

    /**
     * Set the underlying query builder instance.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return $this
     */
    public function setQuery($query)
    {
        $this->methods[] = new Method(__FUNCTION__, [$query]);

        return $this;
    }

    /**
     * Set a model instance for the model being queried.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return $this
     */
    public function setModel(Model $model)
    {
        $this->methods[] = new Method(__FUNCTION__, [$model]);

        return $this;
    }
}
