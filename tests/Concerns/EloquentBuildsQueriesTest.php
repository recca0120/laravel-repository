<?php

namespace Recca0120\Repository\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Recca0120\Repository\Criteria;

class EloquentBuildsQueriesTest extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();
        m::close();
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
        $criteria = Criteria::create()->setQuery(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'setQuery',
            'parameters' => [
                $model,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }
}
