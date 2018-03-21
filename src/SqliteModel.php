<?php

namespace Recca0120\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Recca0120\Repository\SqliteConnectionResolver as ConnectionResolver;

abstract class SqliteModel extends Model
{
    /**
     * $tableCreated.
     *
     * @var array
     */
    protected static $tableCreated = [];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->createTable(parent::getTable());
    }

    /**
     * Resolve a connection instance.
     *
     * @param  string|null  $connection
     * @return \Illuminate\Database\Connection
     */
    public static function resolveConnection($connection = null)
    {
        return ConnectionResolver::getInstance()->connection($connection);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $table
     * @return string
     */
    protected function createTable($table)
    {
        if (isset(static::$tableCreated[$table]) === true) {
            return $table;
        }

        $schema = $this->getConnection()->getSchemaBuilder();
        if ($schema->hasTable($table) === false) {
            $schema->create($table, function (Blueprint $table) {
                $this->createSchema($table);
            });
            static::$tableCreated[$table] = true;
            if ($this instanceof FileModel === true) {
                $this->initializeTable($table);
            }
        }

        return $table;
    }

    /**
     * createSchema.
     *
     * @param  Blueprint $table
     * @return void
     */
    abstract protected function createSchema(Blueprint $table);
}
