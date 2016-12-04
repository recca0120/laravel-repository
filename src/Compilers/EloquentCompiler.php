<?php

namespace Recca0120\Repository\Compilers;

use Closure;
use Recca0120\Repository\Criteria;
use Illuminate\Database\Query\Expression as QueryExpression;

class EloquentCompiler extends Compiler
{
    /**
     * compileParameters.
     *
     * @method compileParameters
     *
     * @param array $params
     *
     * @return array
     */
    protected function compileParameters($params)
    {
        return array_map(function ($param) {
            if ($param instanceof Closure) {
                $criteria = call_user_func($param, new Criteria());

                return function ($query) use ($criteria) {
                    $transform = new static($query);

                    return $transform->push($criteria)->apply();
                };
            }

            if ($this->isExpression($param) === true) {
                return new QueryExpression($param->getValue());
            }

            return $param;
        }, $params);
    }
}
