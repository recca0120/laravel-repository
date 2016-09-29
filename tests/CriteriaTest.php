<?php

use Mockery as m;
use Recca0120\Repository\Criteria;
use Recca0120\Repository\EloquentRepository;

class CriteriaTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function test_call_undefined_criteria()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $criteria = new Criteria();

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $criteria->test();
    }

    public function test_echo_criteria_expression()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertTrue(is_string((string) Criteria::expr('test')));
    }

    public function test_custom_criteria()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('where')->with('foo', '=', 'bar')->once()->andReturnSelf()
            ->shouldReceive('where')->with('fuzz', '=', 'buzz')->once()->andReturnSelf()
            ->shouldReceive('get')->once();

        $repository->get([
            CustomCriteria::create('foo', 'bar'),
            (new CustomCriteria('fuzz', 'buzz')),
        ]);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */
    }

    public function test_criteria_arguments()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        CustomCriteria2::create(1);
        CustomCriteria2::create(1, 2);
        CustomCriteria2::create(1, 2, 3);
        CustomCriteria2::create(1, 2, 3, 4);
        CustomCriteria2::create(1, 2, 3, 4, 5);
    }

    public function test_static_call()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        Criteria::where(1, '=', 1);
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
