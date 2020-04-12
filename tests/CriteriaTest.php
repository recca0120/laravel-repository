<?php

namespace Recca0120\Repository\Tests;

use PHPUnit\Framework\TestCase;
use Recca0120\Repository\Criteria;

class CriteriaTest extends TestCase
{
    public function test_instance()
    {
        $this->assertInstanceOf('Recca0120\Repository\Criteria', new Criteria);
    }

    public function test_create()
    {
        $criteria = Criteria::create();
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_expr()
    {
        $expression = Criteria::expr('foo = bar');
        $this->assertInstanceOf('Recca0120\Repository\Expression', $expression);
        $this->assertSame((string) $expression, 'foo = bar');
    }

    public function test_dynamic_where()
    {
        $criteria = Criteria::create()
            ->whereUrl('http://foo.com')
            ->whereName('foo');

        $this->assertEquals([
            [
                'method' => 'dynamicWhere',
                'parameters' => [
                    'whereUrl',
                    ['http://foo.com'],
                ],
            ],
            [
                'method' => 'dynamicWhere',
                'parameters' => [
                    'whereName',
                    ['foo'],
                ],
            ],
        ], $criteria->toArray());
    }
}
