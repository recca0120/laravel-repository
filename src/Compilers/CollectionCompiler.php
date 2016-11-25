<?php

namespace Recca0120\Repository\Compilers;

use BadMethodCallException;
use Illuminate\Support\Arr;

class CollectionCompiler extends Compiler
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
        $filters = [];
        foreach ($actions as $action) {
            $method = $action['method'];
            $parameters = $action['parameters'];
            if (count($parameters) === 3) {
                list($key, $operator, $value) = $parameters;
            } else {
                list($key, $value) = $parameters;
                $operator = '=';
            }
            if ($value instanceof Expression) {
                $value = $value->getValue();
            }

            $filters[$method][] = [$key, $operator, $value];
        }

        $model = $model->filter(function ($item) use ($filters) {
            foreach ($filters as $method => $rules) {
                switch ($method) {
                    case 'where':
                    case 'having':
                        foreach ($rules as $parameters) {
                            if ($this->checkOperator($item, $parameters) === false) {
                                return false;
                            }
                        }
                        break;
                    default:
                        throw new BadMethodCallException('Call to undefined method '.static::class."::{$method}()");
                        break;
                }
            }

            return true;
        });

        return $model;
    }

    protected function checkOperator($item, $parameters)
    {
        list($key, $operator, $value) = $parameters;
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

        return false;
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
            $sort[$parameters[0]] = Arr::get($parameters, 1, 'asc');
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
     * @param array $sort
     *
     * @return \Closure
     */
    protected function orderComparer($sort)
    {
        return function ($first, $second) use ($sort) {
            foreach ($sort as $key => $orderType) {
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
     * compileParameters.
     *
     * @method compileParameters
     *
     * @param array $parameters
     *
     * @return array
     */
    protected function compileParameters($parameters)
    {
        return $parameters;
    }
}
