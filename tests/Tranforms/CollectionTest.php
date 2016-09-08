<?php

use Mockery as m;
use Illuminate\Support\Collection as Model;
use Recca0120\Repository\Tranforms\Collection;
use Recca0120\Repository\Criteria;

class CollectionTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function test_where_condition()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock(Model::class);
        $tranform = new Collection($model);

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

        foreach (['=', '==', '!=', '<>', '<', '>', '<=', '>=', '===', '!=='] as $operator) {
            $criteria = Criteria::create()
                ->where('foo', $operator, 'bar');
                // ->orWhere('buzz', '=', 'fuzz')
                // ->where(function (Criteria $criteria) {
                //     return $criteria->where('id', '=', 'closure');
                // });

            $model->shouldReceive('filter')->with(m::type(Closure::class))->andReturnUsing(function ($closure) {
                $closure([
                    'foo' => 'bar',
                ]);

                return m::self();
            });

            $this->assertSame($model, $tranform->push($criteria)->apply());
        }
    }

    public function test_having_condition()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock(Model::class);
        $tranform = new Collection($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->having('foo', '=', 'bar');
            // ->orWhere('buzz', '=', 'fuzz')
            // ->where(function (Criteria $criteria) {
            //     return $criteria->where('id', '=', 'closure');
            // });
            $model->shouldReceive('filter')->with(m::type(Closure::class))->once()->andReturnUsing(function ($closure) {
                $closure([
                    'foo' => 'bar',
                ]);

                return m::self();
            });

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $tranform->push($criteria)->apply());
    }

    public function test_order_by_condition()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = [
            ['id' => 1, 'name' => 'Pascal', 'age' => '15'],
            ['id' => 5, 'name' => 'Mark', 'age' => '25'],
            ['id' => 3, 'name' => 'Hugo', 'age' => '55'],
            ['id' => 2, 'name' => 'Angus', 'age' => '25'],
            ['id' => 1, 'name' => 'Pascal', 'age' => '15'],
        ];
        $model = m::mock(Model::class);
        $tranform = new Collection($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->orderBy('age', 'desc')
            ->orderBy('id', 'asc');

        $model->shouldReceive('sort')->with(m::type(Closure::class))->once()->andReturnUsing(function ($callback) use (&$data) {
            uasort($data, $callback);

            $this->assertEquals([
                ['id' => 3, 'name' => 'Hugo', 'age' => '55'],
                ['id' => 2, 'name' => 'Angus', 'age' => '25'],
                ['id' => 5, 'name' => 'Mark', 'age' => '25'],
                ['id' => 1, 'name' => 'Pascal', 'age' => '15'],
                ['id' => 1, 'name' => 'Pascal', 'age' => '15'],
            ], array_values($data));

            return m::self();
        });

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $tranform->push($criteria)->apply());
    }

    public function test_with_condition()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock(Model::class);
        $tranform = new Collection($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->with('table')
            ->with('table2', function (Criteria $criteria) {
                return $criteria->where('id', '=', 'closure');
            });

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $tranform->push($criteria)->apply());
    }

    public function test_join_condition()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock(Model::class);
        $tranform = new Collection($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->join('table2', function (Criteria $criteria) {
                return $criteria->on('table1.id', '=', 'table2.id');
            });

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $tranform->push($criteria)->apply());
    }

    public function test_select_condition()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock(Model::class);
        $tranform = new Collection($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->select('id');

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $tranform->push($criteria)->apply());
    }

    public function test_array_where_condition()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock(Model::class);
        $tranform = new Collection($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = [
            ['foo', '=', 'bar'],
            ['fuzz', 'buzz'],
            'hello' => 'world',
        ];

        $model
            ->shouldReceive('filter')->once()->andReturnSelf()
            ->shouldReceive('where')->with('fuzz', 'buzz')->once()->andReturnSelf()
            ->shouldReceive('where')->with('hello', 'world')->once()->andReturnSelf();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $tranform->push($criteria)->apply());
    }

    public function test_criteria_and_array()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock(Model::class);
        $tranform = new Collection($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = [
            ['foo', '=', 'bar'],
            Criteria::create()
                ->where('fuzz', '=', 'buzz'),
        ];

        $model
            ->shouldReceive('filter')->twice()->andReturnSelf();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $tranform->push($criteria)->apply());
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function test_or_where_condition()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock(Model::class);
        $tranform = new Collection($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->testWhere('foo', '=', 'bar');
            // ->orWhere('buzz', '=', 'fuzz')
            // ->where(function (Criteria $criteria) {
            //     return $criteria->where('id', '=', 'closure');
            // });

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $tranform->push($criteria)->apply());
    }
}
