<?php

namespace Recca0120\Repository;

use Illuminate\Container\Container;
use Illuminate\Database\Connectors\ConnectionFactory;

class SqliteConnectionFactory
{
    private static $instance;

    private static $connections = [];

    public function __construct(ConnectionFactory $factory = null)
    {
        $this->factory = $connectionFactory = new ConnectionFactory(
            Container::getInstance() ?: new Container
        );
    }

    public function make($database = ':memory:', $name = null)
    {
        if (isset(static::$connections[$name]) === true) {
            return static::$connections[$name];
        }

        return static::$connections[$name] = $this->factory->make([
            'driver' => 'sqlite',
            'database' => $database,
        ], $name);
    }

    public static function getInstance(ConnectionFactory $factory = null)
    {
        if (static::$instance) {
            return static::$instance;
        }

        return static::$instance = new static($factory);
    }
}
