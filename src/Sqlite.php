<?php

namespace Recca0120\Repository;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Connectors\ConnectionFactory;

class Sqlite extends Model
{
    protected static $connector;

    protected $database = ':memory:';

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

    public function getConnector()
    {
        if (static::$connector) {
            return static::$connector;
        }

        $connectionFactory = new ConnectionFactory(Container::getInstance());
        $connectionName = md5(__NAMESPACE__);

        return static::$connector = $connectionFactory->make([
            'driver' => 'sqlite',
            'database' => $this->database,
        ], $connectionName);
    }

    protected function createSchema(Blueprint $table)
    {
        $table->increments('id');
        $table->string('foo');
        $table->timestamps();
    }
}
