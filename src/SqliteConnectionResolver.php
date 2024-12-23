<?php

namespace Recca0120\Repository;

use Illuminate\Container\Container;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Connectors\ConnectionFactory;

class SqliteConnectionResolver implements ConnectionResolverInterface
{
    /**
     * All of the registered connections.
     *
     * @var array
     */
    protected $connections = [];

    /**
     * The default connection name.
     *
     * @var string
     */
    protected $default = 'default';

    /**
     * The current globally available container (if any).
     *
     * @var static
     */
    private static $instance;

    /** @var ConnectionFactory */
    private $factory;

    public function __construct(?ConnectionFactory $factory = null)
    {
        $this->factory = $factory ?? new ConnectionFactory(Container::getInstance() ?: new Container);
    }

    /**
     * Get a database connection instance.
     *
     * @param  string  $name
     * @return ConnectionInterface
     */
    public function connection($name = null)
    {
        if (is_null($name)) {
            $name = $this->getDefaultConnection();
        }

        if (isset($this->connections[$name]) === false) {
            $this->connections[$name] = $this->factory->make([
                'driver' => 'sqlite',
                'database' => ':memory:',
            ], $name);
        }

        return $this->connections[$name];
    }

    /**
     * Get the default connection name.
     *
     * @return string
     */
    public function getDefaultConnection()
    {
        return $this->default;
    }

    /**
     * Set the default connection name.
     *
     * @param  string  $name
     * @return void
     */
    public function setDefaultConnection($name)
    {
        $this->default = $name;
    }

    /**
     * Set the globally available instance of the SqliteConnectionResolver.
     *
     * @return static
     */
    public static function getInstance(?ConnectionFactory $factory = null)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static($factory);
        }

        return static::$instance;
    }
}
