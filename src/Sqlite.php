<?php

namespace Recca0120\Repository;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Connectors\ConnectionFactory;

abstract class Sqlite extends Model
{
    /**
     * $database
     *
     * @var string
     */
    protected $database = ':memory:';

    /**
     * $connector
     *
     * @var \Illuminate\Database\Connection
     */
    protected static $connector;

    /**
     * Get a schema builder instance.
     *
     * @return \Illuminate\Database\Schema\Builder
     */
    public function schema()
    {
        return $this->getConnector()->getSchemaBuilder();
    }

    /**
     * Get the database connection for the model.
     *
     * @return \Illuminate\Database\Connection
     */
    public function getConnection()
    {
        $table = $this->getTable();
        $schema = $this->schema();

        if ($schema->hasTable($table) === false) {
            $schema->create($table, function (Blueprint $table) {
                $this->createSchema($table);
            });
        }

        return $this->getConnector();
    }

    /**
     * Establish a PDO connection based on the configuration.
     *
     * @return \Illuminate\Database\Connection
     */
    public function getConnector()
    {
        if (self::$connector) {
            return self::$connector;
        }

        $connectionFactory = new ConnectionFactory(Container::getInstance());
        $connectionName = md5(__NAMESPACE__);

        return self::$connector = $connectionFactory->make([
            'driver' => 'sqlite',
            'database' => $this->database,
        ], $connectionName);
    }

    /**
     * createSchema
     *
     * @param  Blueprint $table
     * @return void
     */
    protected function createSchema(Blueprint $table)
    {
        $table->increments('id');
        $table->string('foo');
        $table->timestamps();
    }
}
