<?php

namespace Recca0120\Repository\Tests\Concerns;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Recca0120\Repository\Criteria;

class QueriesRelationshipsTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_has()
    {
        $criteria = Criteria::create()->has(
            $relation = 'foo',
            $operator = '<=',
            $count = 2,
            $boolean = 'or',
            $callback = function () {
            }
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'has',
            'parameters' => [
                $relation,
                $operator,
                $count,
                $boolean,
                $callback,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_or_has()
    {
        $criteria = Criteria::create()->orHas(
            $relation = 'foo',
            $operator = '<=',
            $count = 2
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'orHas',
            'parameters' => [
                $relation,
                $operator,
                $count,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_doesnt_have()
    {
        $criteria = Criteria::create()->doesntHave(
            $relation = 'foo',
            $boolean = 'or',
            $callback = function () {
            }
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'doesntHave',
            'parameters' => [
                $relation,
                $boolean,
                $callback,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_where_has()
    {
        $criteria = Criteria::create()->whereHas(
            $relation = 'foo',
            $callback = function () {
            },
            $operator = '<=',
            $count = 2
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'whereHas',
            'parameters' => [
                $relation,
                $callback,
                $operator,
                $count,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_or_where_has()
    {
        $criteria = Criteria::create()->orWhereHas(
            $relation = 'foo',
            $callback = function () {
            },
            $operator = '<=',
            $count = 2
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'orWhereHas',
            'parameters' => [
                $relation,
                $callback,
                $operator,
                $count,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_where_doesnt_have()
    {
        $criteria = Criteria::create()->whereDoesntHave(
            $relation = 'foo',
            $callback = function () {
            }
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'whereDoesntHave',
            'parameters' => [
                $relation,
                $callback,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_with_count()
    {
        $criteria = Criteria::create()->withCount(
            $relation = 'foo'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'withCount',
            'parameters' => [
                $relation,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_merge_constraints_from()
    {
        $criteria = Criteria::create()->mergeConstraintsFrom(
            $from = m::mock('Illuminate\Database\Eloquent\Builder')
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'mergeConstraintsFrom',
            'parameters' => [
                $from,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }
}
