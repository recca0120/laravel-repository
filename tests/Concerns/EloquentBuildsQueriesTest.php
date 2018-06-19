<?php

namespace Recca0120\Repository\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Recca0120\Repository\Criteria;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class EloquentBuildsQueriesTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testWhereKey()
    {
        $criteria = Criteria::create()->whereKey($id = 'foo');
        $this->assertSame($criteria->toArray(), [[
            'method' => 'whereKey',
            'parameters' => [
                $id,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function testWhereKeyNot()
    {
        $criteria = Criteria::create()->whereKeyNot($id = 'foo');
        $this->assertSame($criteria->toArray(), [[
            'method' => 'whereKeyNot',
            'parameters' => [
                $id,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function testWith()
    {
        $criteria = Criteria::create()->with(
            $relations = 'foo'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'with',
            'parameters' => [
                $relations,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function testWithout()
    {
        $criteria = Criteria::create()->without(
            $relations = 'foo'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'without',
            'parameters' => [
                $relations,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function testSetQuery()
    {
        $criteria = Criteria::create()->setQuery(
            $query = m::mock('Illuminate\Database\Query\Builder')
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'setQuery',
            'parameters' => [
                $query,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function testSetModel()
    {
        $criteria = Criteria::create()->setModel(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'setModel',
            'parameters' => [
                $model,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function testOnWriteConnection()
    {
        $criteria = Criteria::create()->onWriteConnection();
        $this->assertSame($criteria->toArray(), [[
            'method' => 'useWritePdo',
            'parameters' => [],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }
}
