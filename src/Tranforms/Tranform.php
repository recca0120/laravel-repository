<?php

namespace Recca0120\Repository\Tranforms;

use Recca0120\Repository\Criteria;

abstract class Tranform
{
    public function apply($model, Criteria $criteria)
    {
        $criteria->each(function ($action) use (&$model) {
            $method = (method_exists($this, $action->method) === true) ?
                $this->method : 'default';
            $model = call_user_func_array([$this, $method], [
                $model,
                $this->transformParameters($action->parameters),
                $action,
            ]);
        });

        return $model;
    }

    public function default($model, $parameters, $action)
    {
        return call_user_func_array([$model, $action->method], $parameters);
    }

    abstract protected function transformParameters($parameters);
}
