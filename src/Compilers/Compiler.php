<?php

namespace Recca0120\Repository\Compilers;

use Recca0120\Repository\Criteria;
use Recca0120\Repository\Expression;

abstract class Compiler
{
    /**
     * $items.
     *
     * @var array
     */
    protected $items = [];

    /**
     * $model.
     *
     * @var mixed
     */
    protected $model;

    /**
     * __construct.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * push.
     *
     * @param \Recca0120\Repository\Criteria $criteria
     * @return $this
     */
    public function push($criteria)
    {
        $items = is_array($criteria) ? $criteria : [$criteria];

        foreach ($items as $key => $value) {
            if (($value instanceof Criteria) === true) {
                $this->items[] = $value;
            } else {
                $value = is_array($value) ? $value : [$key, $value];
                $criteria = call_user_func_array([Criteria::create(), 'where'], $value);
                $this->items[] = $criteria;
            }
        }

        return $this;
    }

    /**
     * apply.
     *
     * @return mixed
     */
    public function apply()
    {
        foreach ($this->group() as $type => $actions) {
            $method = method_exists($this, $type) === true ? $type : 'defaults';
            $this->model = call_user_func_array([$this, $method], [$this->model, $actions]);
        }

        return $this->model;
    }

    /**
     * defaults apply.
     *
     * @param mixed $model
     * @param array $actions
     * @return mixed
     */
    public function defaults($model, $actions)
    {
        return array_reduce($actions, function ($model, $action) {
            return call_user_func_array([$model, $action['method']], $action['parameters']);
        }, $model);
    }

    /**
     * isExpression.
     *
     * @param mixed$param
     * @return bool
     */
    protected function isExpression($param)
    {
        return $param instanceof Expression;
    }

    /**
     * group.
     *
     * @return array
     */
    protected function group()
    {
        return array_reduce($this->items, function ($allows, $criteria) {
            foreach ($criteria->all() as $action) {
                $allows[$action->type][] = [
                    'method' => $action->method,
                    'parameters' => $this->compileParameters($action->parameters),
                ];
            }

            return $allows;
        }, []);
    }

    /**
     * transformParameters.
     *
     * @param array $parameters
     * @return array
     */
    abstract protected function compileParameters($parameters);
}
