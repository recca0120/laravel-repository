<?php

namespace Recca0120\Repository\Matchers;

use Closure;
use Illuminate\Database\Query\Expression as QueryExpression;
use Recca0120\Repository\Criteria;
use Recca0120\Repository\Criteria\Expression as CriteriaExpression;

class CollectionMatcher extends Matcher
{
    /**
     * applyCriteria.
     *
     * @method applyCriteria
     *
     * @param mixed                                 $model
     * @param \Recca0120\Repository\Criteria\Action $action
     *
     * @return mixed
     */
    protected function applyCriteria($model, $action)
    {
        if (empty($action->parameters) === true) {
            return $model;
        }

        return call_user_func_array([$model, $action->method], array_map(function ($parameter) {
            if ($parameter instanceof Closure) {
                $criteria = call_user_func($parameter, new Criteria());

                return function ($query) use ($criteria) {
                    return $this->apply($query, $criteria);
                };
            }

            if ($parameter instanceof CriteriaExpression) {
                return new QueryExpression($parameter->getValue());
            }

            return $parameter;
        }, $action->parameters));
    }

    protected function applyCriteriaWhere($model, $action)
    {
        if (count($action->parameters) === 3) {
            return $model->filter(function ($item) use ($action) {
                list($key, $op, $value) = $action->parameters;
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

        return $model->where($action->parameters[0], $action->parameters[1]);
    }
}
