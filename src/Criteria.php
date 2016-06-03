<?php

namespace Recca0120\Repository;

use Recca0120\Repository\Criteria\Expression;

class Criteria
{
    protected $bindings = [
        'select'  => [],
        'where'   => [],
        'join'    => [],
        'having'  => [],
        'order'   => [],
        'union'   => [],
        'groupBy' => [],
        'on'      => [],
    ];

    protected function addBinding($type, $method, $parameters)
    {
        $this->bindings[$type][] = [
            'method'     => strtolower($method),
            'parameters' => $parameters,
        ];

        return $this;
    }

    public function getBindings()
    {
        return $this->bindings;
    }

    public function __call($method, $parameters)
    {
        if (preg_match('/'.implode('|', array_keys($this->bindings)).'/i', $method, $match) !== false) {
            $this->addBinding($match[0], $method, $parameters);
        }

        return $this;
    }

    public static function expr($value)
    {
        return static::raw($value);
    }

    public static function raw($value)
    {
        return new Expression($value);
    }

    public static function create()
    {
        return new static();
    }
}
