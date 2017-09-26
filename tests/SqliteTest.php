<?php

namespace Recca0120\Repository\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Recca0120\Repository\Sqlite;

class SqliteTest extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    public function testInstance()
    {
        $model = new Sqlite();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $model);
    }
}
