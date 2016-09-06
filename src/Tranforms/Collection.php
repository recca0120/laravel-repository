<?php

namespace Recca0120\Repository\Tranforms;

use BadMethodCallException;
use Recca0120\Repository\Criteria\Expression as CriteriaExpression;

class Collection extends Tranform
{
    /**
     * where.
     *
     * @method where
     *
     * @param mixed $model
     * @param array $actions
     *
     * @return mixed
     */
    public function where($model, $actions)
    {
        foreach ($actions as $action) {
            $method = $action['method'];
            $parameters = $action['parameters'];
            if (in_array($method, ['where', 'having'], true) === true) {
                if (count($parameters) === 3) {
                    $model = $model->filter(function ($item) use ($parameters) {
                        list($key, $operator, $value) = $parameters;
                        if ($value instanceof CriteriaExpression) {
                            return $value->getValue();
                        }
                        $retrieved = $item[$key];
                        switch ($operator) {
                            case '=':
                            case '==':  return $retrieved == $value;
                            case '!=':
                            case '<>':  return $retrieved != $value;
                            case '<':   return $retrieved < $value;
                            case '>':   return $retrieved > $value;
                            case '<=':  return $retrieved <= $value;
                            case '>=':  return $retrieved >= $value;
                            case '===': return $retrieved === $value;
                            case '!==': return $retrieved !== $value;
                        }
                    });
                } else {
                    $model = $model->where($parameters[0], $parameters[1]);
                }
            } else {
                throw new BadMethodCallException('Call to undefined method '.static::class."::{$method}()");
            }
        }

        return $model;
    }

    /**
     * having.
     *
     * @method having
     *
     * @param mixed $model
     * @param array $actions
     *
     * @return mixed
     */
    public function having($model, $actions)
    {
        return $this->where($model, $actions);
    }

    /**
     * order.
     *
     * @method order
     *
     * @param mixed $model
     * @param array $actions
     *
     * @return mixed
     */
    public function order($model, $actions)
    {
        $sort = [];
        foreach ($actions as $action) {
            $parameters = $action['parameters'];
            $sort[$parameters[0]] = array_get($parameters, 1, 'asc');
        }

        return $model->sort($this->orderComparer($sort));
    }

    /**
     * with.
     *
     * @method with
     *
     * @param mixed $model
     * @param array $actions
     *
     * @return mixed
     */
    public function with($model, $actions)
    {
        return $model;
    }

    /**
     * join.
     *
     * @method join
     *
     * @param mixed $model
     * @param array $actions
     *
     * @return mixed
     */
    public function join($model, $actions)
    {
        return $model;
    }

    /**
     * select.
     *
     * @method select
     *
     * @param mixed $model
     * @param array $actions
     *
     * @return mixed
     */
    public function select($model, $actions)
    {
        return $model;
    }

    /**
     * orderComparer.
     *
     * @method orderComparer
     *
     * @param array $criteria
     *
     * @return \Closure
     */
    protected function orderComparer($criteria)
    {
        return function ($first, $second) use ($criteria) {
            foreach ($criteria as $key => $orderType) {
                // normalize sort direction
                $orderType = strtolower($orderType);
                if (data_get($first, $key) < data_get($second, $key)) {
                    return $orderType === 'asc' ? -1 : 1;
                } elseif (data_get($first, $key) > data_get($second, $key)) {
                    return $orderType === 'asc' ? 1 : -1;
                }
            }
            // all elements were equal
            return 0;
        };
    }

    /**
     * transformParameters.
     *
     * @method transformParameters
     *
     * @param array $parameters
     *
     * @return array
     */
    protected function transformParameters($parameters)
    {
        return $parameters;
    }
}
