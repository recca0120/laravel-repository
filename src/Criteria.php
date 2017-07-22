<?php

namespace Recca0120\Repository;

class Criteria
{
    use Concerns\BuildsQueries;
    use Concerns\QueriesRelationships;

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
