<?php

namespace Recca0120\Repository\Tranforms;

use Recca0120\Repository\Criteria\Expression as CriteriaExpression;

class Collection extends Tranform
{
    public function where($model, $parameters, $action)
    {
        if (count($parameters) === 3) {
            return $model->filter(function ($item) use ($parameters) {
                list($key, $op, $value) = $parameters;
                if ($value instanceof CriteriaExpression) {
                    return $value->getValue();
                }
                switch ($op) {
                    case '>':
                        return $item[$key] > $value;
                        break;
                    case '>=':
                        return $item[$key] >= $value;
                        break;
                    case '<':
                        return $item[$key] > $value;
                        break;
                    case '<=':
                        return $item[$key] >= $value;
                        break;
                    case '=':
                        return $item[$key] == $value;
                        break;
                }
            });
        }

        return $model->where($parameters[0], $parameters[1]);
    }

    protected function transformParameters($parameters)
    {
        return $parameters;
    }
}
