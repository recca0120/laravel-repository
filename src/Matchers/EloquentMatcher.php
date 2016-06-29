<?php

namespace Recca0120\Repository\Matchers;

use Closure;
use Illuminate\Database\Query\Expression as QueryExpression;
use Recca0120\Repository\Criteria;
use Recca0120\Repository\Criteria\Expression as CriteriaExpression;

class EloquentMatcher extends Matcher
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
        // if (empty($action->parameters) === true) {
        //     return $model;
        // }

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
}
