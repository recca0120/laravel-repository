<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Expression;
use Mockery as m;
use Recca0120\Repository\Criteria;
use Recca0120\Repository\EloquentRepository;

class EloquentRepositoryTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testNewInstance()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock(Model::class);
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model->shouldReceive('forceFill')->once();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $repository->newInstance();
    }

    public function testCreate()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = m::mock(Model::class);
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model->shouldReceive('create')->with($data)->once()->andReturnSelf();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $repository->create($data));
    }

    public function testFind()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $id = 1;
        $model = m::mock(Model::class);
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model->shouldReceive('find')->with($id)->once()->andReturnSelf();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $repository->find($id));
    }

    public function testUpdate()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $id = 1;
        $data = ['foo' => 'bar'];
        $model = m::mock(Model::class);
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('find')->with($id)->once()->andReturnSelf()
            ->shouldReceive('fill')->with($data)->once()->andReturnSelf()
            ->shouldReceive('save')->once();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $repository->update($data, $id));
    }

    public function testDelete()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $id = 1;
        $model = m::mock(Model::class);
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('find')->with($id)->once()->andReturnSelf()
            ->shouldReceive('delete')->once()->andReturn(true);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertTrue($repository->delete($id));
    }

    public function testFindBy()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = m::mock(Model::class);
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('take')->once()->with(10)->andReturnSelf()
            ->shouldReceive('skip')->once()->with(5)->andReturnSelf()
            ->shouldReceive('get')->once()->andReturn($data);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($data, $repository->findBy([], 10, 5));
    }

    public function testFindAll()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = m::mock(Model::class);
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model->shouldReceive('get')->once()->andReturn($data);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($data, $repository->findAll());
    }

    public function testPaginatedBy()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = m::mock(Model::class);
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model->shouldReceive('paginate')->with(1, ['*'], 'page', 1)->once()->andReturn($data);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($data, $repository->paginatedBy([], 1, 'page', 1));
    }

    public function testPaginatedAll()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = m::mock(Model::class);
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model->shouldReceive('paginate')->with(1, ['*'], 'page', 1)->andReturn($data);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($data, $repository->paginatedAll(1, 'page', 1));
    }

    public function testFindOneBy()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = m::mock(Model::class);
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model->shouldReceive('first')->once()->andReturn($data);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($data, $repository->findOneBy([]));
    }

    public function testFindByCriteriaWhere()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock(Model::class);
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->where('foo', '=', 'bar')
            ->orWhere('buzz', '=', 'fuzz')
            ->where(function (Criteria $criteria) {
                return $criteria->where('id', '=', 'closure');
            });

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('where')->with('foo', '=', 'bar')->once()->andReturnSelf()
            ->shouldReceive('orWhere')->with('buzz', '=', 'fuzz')->once()->andReturnSelf()
            ->shouldReceive('where')->with(m::type(Closure::class))->once()->andReturnUsing(function ($closure) {
                $tranform = $closure(m::self());

                return m::self();
            })
            ->shouldReceive('where')->with('id', '=', 'closure')->once()->andReturnSelf()
            ->shouldReceive('get')->once();

        $repository->findBy($criteria);
    }

    public function testFindByCriteriaHaving()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock(Model::class);
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->having('foo', '=', 'bar')
            ->orHaving('buzz', '=', 'fuzz')
            ->having(function (Criteria $criteria) {
                return $criteria->having('id', '=', 'closure');
            });

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('having')->with('foo', '=', 'bar')->once()->andReturnSelf()
            ->shouldReceive('orHaving')->with('buzz', '=', 'fuzz')->once()->andReturnSelf()
            ->shouldReceive('having')->with(m::type(Closure::class))->once()->andReturnUsing(function ($closure) {
                $tranform = $closure(m::self());

                return m::self();
            })
            ->shouldReceive('having')->with('id', '=', 'closure')->once()->andReturnSelf()
            ->shouldReceive('get')->once();

        $repository->findBy($criteria);
    }

    public function testFindByCriteriaGroupBy()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock(Model::class);
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->groupBy('id');

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('groupBy')->with('id')->once()->andReturnSelf()
            ->shouldReceive('get')->once();
        $repository->findBy($criteria);
    }

    public function testFindByCriteriaOrderBy()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock(Model::class);
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->orderBy('id');

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('orderBy')->with('id')->once()->andReturnSelf()
            ->shouldReceive('get')->once();
        $repository->findBy($criteria);
    }

    public function testFindByCriteriaWith()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock(Model::class);
        $repository = new EloquentRepository($model);

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

        $model
            ->shouldReceive('with')->with('table')->once()->andReturnSelf()
            ->shouldReceive('with')->with('table2', m::type(Closure::class))->once()->andReturnSelf()
            ->shouldReceive('get')->once();
        $repository->findBy($criteria);
    }

    public function testFindByCriteriaJoin()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock(Model::class);
        $repository = new EloquentRepository($model);

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

        $model
            ->shouldReceive('join')->with('table2', m::type(Closure::class))->once()->andReturnSelf()
            ->shouldReceive('get')->once();
        $repository->findBy($criteria);
    }

    public function testFindByCriteriaSelect()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock(Model::class);
        $repository = new EloquentRepository($model);

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

        $model
            ->shouldReceive('select')->with('id')->once()->andReturnSelf()
            ->shouldReceive('get')->once();
        $repository->findBy($criteria);
    }

    public function testFindByCriteriaSelectExpression()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock(Model::class);
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->select(Criteria::expr('id'));

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('select')->with(m::type(Expression::class))->once()->andReturnSelf()
            ->shouldReceive('get')->once();
        $repository->findBy($criteria);
    }

    public function testFindByArray()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock(Model::class);
        $repository = new EloquentRepository($model);

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

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('where')->with('foo', '=', 'bar')->once()->andReturnSelf()
            ->shouldReceive('where')->with('fuzz', 'buzz')->once()->andReturnSelf()
            ->shouldReceive('where')->with('hello', 'world')->once()->andReturnSelf()
            ->shouldReceive('get')->once();
        $repository->findBy($criteria);
    }

    public function testFindByCriteriaAndArray()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock(Model::class);
        $repository = new EloquentRepository($model);

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

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('where')->with('foo', '=', 'bar')->once()->andReturnSelf()
            ->shouldReceive('where')->with('fuzz', '=', 'buzz')->once()->andReturnSelf()
            ->shouldReceive('get')->once();
        $repository->findBy($criteria);
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testCallUndefinedCriteria()
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

    public function testEchoCriteriaExpression()
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

    public function testCustomCriteria()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock(Model::class);
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

        $repository->findBy([
            CustomCriteria::create('foo', 'bar'),
            (new CustomCriteria('fuzz', 'buzz')),
        ]);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */
    }

    public function testCriteriaArguments()
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
