<?php

namespace Recca0120\Repository\Tests;

use PHPUnit\Framework\TestCase;
use Recca0120\Repository\Criteria;
use Recca0120\Repository\Expression;

class CriteriaTest extends TestCase
{
    public function test_instance()
    {
        $this->assertInstanceOf(Criteria::class, new Criteria);
    }

    public function test_create()
    {
        $criteria = Criteria::create();
        $this->assertInstanceOf(Criteria::class, $criteria);
    }

    public function test_expr()
    {
        $expression = Criteria::expr('foo = bar');
        $this->assertInstanceOf(Expression::class, $expression);
        $this->assertEquals('foo = bar', (string) $expression);
    }

    public function test_dynamic_where()
    {
        $criteria = Criteria::create()->whereUrl('https://foo.com')->whereName('foo');

        $this->assertEquals([
            [
                'method' => 'dynamicWhere',
                'parameters' => ['whereUrl', ['https://foo.com']],
            ],
            [
                'method' => 'dynamicWhere',
                'parameters' => ['whereName', ['foo']],
            ],
        ], $criteria->toArray());
    }
}
