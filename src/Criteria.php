<?php

namespace Recca0120\Repository;

use BadMethodCallException;
use Closure;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * @mixin QueryBuilder
 * @mixin EloquentBuilder
 */
class Criteria
{
    use Concerns\SoftDeletingScope;

    protected $proxies = [
        EloquentBuilder::class,
        QueryBuilder::class,
    ];
    /**
     * $methods.
     *
     * @var Method[]
     */
    protected $methods = [];

    private static $cache = [];

    /**
     * Handle dynamic method calls into the method.
     *
     * @param string $method
     * @param array $parameters
     * @return Criteria
     *
     * @throws BadMethodCallException
     * @throws ReflectionException
     */
    public function __call($method, $parameters)
    {
        $hasMethod = $this->hasMethod($method);
        if ($hasMethod) {
            $this->methods[] = new Method($method, $parameters);

            return $this;
        }

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

    /**
     * Begin querying the model on the write connection.
     *
     * @return Criteria
     */
    public function onWriteConnection()
    {
        return $this->useWritePdo();
    }

    /**
     * @param string $class
     * @return string[]
     * @throws ReflectionException
     */
    private function findMethods($class)
    {
        if (array_key_exists($class, self::$cache)) {
            return self::$cache[$class];
        }

        $ref = new ReflectionClass($class);

        return self::$cache[$class] = array_flip(array_map(static function ($method) {
            return $method->getName();
        }, $ref->getMethods(ReflectionMethod::IS_PUBLIC)));
    }

    /**
     * @param string $method
     * @return bool
     * @throws ReflectionException
     */
    private function hasMethod(string $method)
    {
        foreach ($this->proxies as $proxy) {
            $methods = $this->findMethods($proxy);
            if (array_key_exists($method, $methods)) {
                return true;
            }
        }

        return false;
    }
}
