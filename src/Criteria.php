<?php

namespace Recca0120\Repository;

use BadMethodCallException;
use Closure;
use Illuminate\Support\Str;

class Criteria
{
    use Concerns\BuildsQueries,
        Concerns\QueriesRelationships,
        Concerns\EloquentBuildsQueries,
        Concerns\SoftDeletingScope;

    /**
     * $methods.
     *
     * @var Method[]
     */
    protected $methods = [];

    /**
     * Handle dynamic method calls into the method.
     *
     * @param string $method
     * @param array $parameters
     * @return Criteria
     *
     * @throws BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if (Str::startsWith($method, 'where')) {
            return $this->dynamicWhere($method, $parameters);
        }

        $className = static::class;

        throw new BadMethodCallException("Call to undefined method {$className}::{$method}()");
    }

    /**
     * create.
     *
     * @return static
     */
    public static function create()
    {
        return new static();
    }

    /**
     * alias raw.
     *
     * @param mixed $value
     * @return Expression
     */
    public static function expr($value)
    {
        return static::raw($value);
    }

    /**
     * @param mixed $value
     * @return Expression
     */
    public static function raw($value)
    {
        return new Expression($value);
    }

    /**
     * each.
     *
     * @param Closure $callback
     * @return void
     */
    public function each(Closure $callback)
    {
        foreach ($this->methods as $method) {
            $callback($method);
        }
    }

    /**
     * toArray.
     *
     * @return array
     */
    public function toArray()
    {
        return array_map(static function ($method) {
            return [
                'method' => $method->name,
                'parameters' => $method->parameters,
            ];
        }, $this->methods);
    }
}
