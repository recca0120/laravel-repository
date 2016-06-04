<?php

namespace Recca0120\Repository\Filters;

use Closure;
use Illuminate\Database\Query\Expression as QueryExpression;
use Recca0120\Repository\Criteria;
use Recca0120\Repository\Criteria\Expression as CriteriaExpression;

class EloquentFilter extends Filter
{
    /**
     * applyCriteria.
     * @method applyCriteria
     * @param  mixed        $model
     * @param  \Recca0120\Repository\Criteria\Item        $criteriaItem  
     * @return mixed
     */
    protected function applyCriteria($model, $criteriaItem)
    {
        if (empty($criteriaItem->parameters) === true) {
            return $model;
        }

        return call_user_func_array([$model, $criteriaItem->method], array_map(function ($parameter) {
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
        }, $criteriaItem->parameters));
    }
}
