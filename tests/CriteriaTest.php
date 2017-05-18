<?php

namespace Recca0120\Repository\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Recca0120\Repository\Criteria;
use Recca0120\Repository\EloquentRepository;

class CriteriaTest extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testCallUndefinedCriteria()
    {
        $criteria = new Criteria();
        $criteria->test();
    }

    public function testEchoCriteriaExpression()
    {
        $this->assertTrue(is_string((string) Criteria::expr('test')));
    }

    public function testCustomCriteria()
    {
        $repository = new EloquentRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('where')->with('foo', '=', 'bar')->once()->andReturnSelf();
        $model->shouldReceive('where')->with('fuzz', '=', 'buzz')->once()->andReturnSelf();
        $model->shouldReceive('get')->once()->andReturn(
            $results = m::mock('stdClass')
        );
        $this->assertSame($results, $repository->get([
            CustomCriteria::create('foo', 'bar'),
            (new CustomCriteria('fuzz', 'buzz')),
        ]));
    }

    public function testCriteriaArguments()
    {
        $this->assertInstanceOf('Recca0120\Repository\Criteria', CustomCriteria2::create(1));
        $this->assertInstanceOf('Recca0120\Repository\Criteria', CustomCriteria2::create(1, 2));
        $this->assertInstanceOf('Recca0120\Repository\Criteria', CustomCriteria2::create(1, 2, 3));
        $this->assertInstanceOf('Recca0120\Repository\Criteria', CustomCriteria2::create(1, 2, 3, 4));
        $this->assertInstanceOf('Recca0120\Repository\Criteria', CustomCriteria2::create(1, 2, 3, 4, 5));
    }

    public function testStaticCall()
    {
        $this->assertInstanceOf('Recca0120\Repository\Criteria', Criteria::where(1, '=', 1));
    }
}

class CustomCriteria extends Criteria
{
    public function __construct($a, $b)
    {
        $this->where($a, '=', $b);
    }
}

class CustomCriteria2 extends Criteria
{
    public function __construct()
    {
    }
}
