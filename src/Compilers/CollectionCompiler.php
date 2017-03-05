<?php

namespace Recca0120\Repository\Compilers;

use BadMethodCallException;
use Illuminate\Support\Arr;
use Recca0120\Repository\Expression;

class CollectionCompiler extends Compiler
{
    /**
     * where.
     *
     * @param mixed $model
     * @param array $actions
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
                }
            }

            return true;
        });

        return $model;
    }

    /**
     * checkOperator.
     *
     * @param mix $item
     * @param array $parameters
     * @return bool
     */
    protected function checkOperator($item, $parameters)
    {
        list($key, $operator, $value) = $parameters;
        $retrieved = $item[$key];
        switch ($operator) {
            case '=':
            case '==': return $retrieved == $value;
            case '!=':
            case '<>': return $retrieved != $value;
            case '<': return $retrieved < $value;
            case '>': return $retrieved > $value;
            case '<=': return $retrieved <= $value;
            case '>=': return $retrieved >= $value;
            case '===': return $retrieved === $value;
            case '!==': return $retrieved !== $value;
        }

        return false;
    }

    /**
     * having.
     *
     * @param mixed $model
     * @param array $actions
     * @return mixed
     */
    public function having($model, $actions)
    {
        return $this->where($model, $actions);
    }

    /**
     * order.
     *
     * @param mixed $model
     * @param array $actions
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
     * @param mixed $model
     * @param array $actions
     * @return mixed
     */
    public function with($model, $actions)
    {
        return $model;
    }

    /**
     * join.
     *
     * @param mixed $model
     * @param array $actions
     * @return mixed
     */
    public function join($model, $actions)
    {
        return $model;
    }

    /**
     * select.
     *
     * @param mixed $model
     * @param array $actions
     * @return mixed
     */
    public function select($model, $actions)
    {
        return $model;
    }

    /**
     * orderComparer.
     *
     * @param array $sort
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
     * @param array $parameters
     * @return array
     */
    protected function compileParameters($parameters)
    {
        return $parameters;
    }
}
