<?php

namespace Recca0120\Repository\Tests;

use PHPUnit\Framework\TestCase;
use Recca0120\Repository\Criteria;

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
