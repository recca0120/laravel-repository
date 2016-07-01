<?php

namespace Recca0120\Repository\Tranforms;

use Closure;
use Illuminate\Database\Query\Expression as QueryExpression;
use Recca0120\Repository\Criteria;
use Recca0120\Repository\Criteria\Expression as CriteriaExpression;

class Eloquent extends Tranform
{
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
        return array_map(function ($parameter) {
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
        }, $parameters);
    }
}
