<?php

namespace Recca0120\Repository;

use Closure;

class Criteria
{
    use Concerns\BuildsQueries,
        Concerns\QueriesRelationships,
        Concerns\EloquentBuildsQueries;

    /**
     * $methods.
     *
     * @var \Recca0120\Repository\Method[]
     */
    protected $methods;

    /**
     * create.
     *
     * @return static
     */
    public static function create()
    {
        return new static;
    }

    /**
     * each.
     *
     * @param  Closure $callback
     * @return void
     */
    public function each(Closure $callback)
    {
        foreach ($this->methods as $method) {
            $callback($method);
        }
    }

    /**
     * all.
     *
     * @return  \Recca0120\Repository\Method[]
     */
    public function all()
    {
        return $this->methods;
    }

    /**
     * toArray.
     *
     * @return array
     */
    public function toArray()
    {
        return array_map(function ($method) {
            return [
                'method' => $method->method,
                'parameters' => $method->parameters,
            ];
        }, $this->methods);
    }
}
