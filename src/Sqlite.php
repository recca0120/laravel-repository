<?php

namespace Recca0120\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

abstract class Sqlite extends Model
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
        return SqliteConnectionResolver::getInstance()->connection($connection);
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
