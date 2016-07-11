<?php

use Illuminate\Support\Collection;
use Mockery as m;
use Recca0120\Repository\CollectionRepository;
use Recca0120\Repository\Criteria;

class CollectionRepositoryTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    protected function mockCollection()
    {
        return m::mock(Collection::class)
            ->shouldReceive('make')->once()->andReturnSelf()
            ->shouldReceive('map')->andReturnSelf()
            ->mock();
    }

    public function testNewInstance()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

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
        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        // $model->shouldReceive('create')->with($data)->once()->andReturnSelf();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $repository->create($data);
        // $this->assertSame($model, $repository->create($data));
    }

    public function testFind()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $id = 1;
        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('where')->with('id', $id)->andReturnSelf()
            ->shouldReceive('first')->andReturnSelf();

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
        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

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

        $repository->update($data, $id);
        // $this->assertSame($model, $repository->update($data, $id));
    }

    public function testDelete()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $id = 1;
        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

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

        $repository->delete($id);
        // $this->assertTrue($repository->delete($id));
    }

    public function testFindBy()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('take')->with(10)->once()->andReturnSelf()
            ->shouldReceive('skip')->with(5)->once()->andReturnSelf()
            ->shouldReceive('toArray')->once()->andReturn($data);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($data, $repository->findBy([], 10, 5)->toArray());
    }

    public function testFindAll()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model->shouldReceive('toArray')->once()->andReturn($data);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($data, $repository->findAll()->toArray());
    }

    public function testPaginatedBy()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('count')->once()->andReturn(10)
            ->shouldReceive('forPage')->once()->andReturnSelf()
            ->shouldReceive('all')->once()->andReturn($data);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($data, $repository->paginatedBy([], 1, 'page', 1)->items());
    }

    public function testPaginatedAll()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('count')->once()->andReturn(10)
            ->shouldReceive('forPage')->once()->andReturnSelf()
            ->shouldReceive('all')->once()->andReturn($data);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($data, $repository->paginatedAll(1, 'page', 1)->items());
    }

    public function testFindOneBy()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

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

        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->where('foo', '=', 'bar');
            // ->orWhere('buzz', '=', 'fuzz')
            // ->where(function (Criteria $criteria) {
            //     return $criteria->where('id', '=', 'closure');
            // });

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $model->shouldReceive('filter')->with(m::type(Closure::class))->once()->andReturnSelf();

        $repository->findBy($criteria);
    }

    public function testFindByCriteriaHaving()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

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

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $model->shouldReceive('filter')->with(m::type(Closure::class))->once()->andReturnSelf();

        $repository->findBy($criteria);
    }

    // public function testFindByCriteriaGroupBy()
    // {
    //     /*
    //     |------------------------------------------------------------
    //     | Set
    //     |------------------------------------------------------------
    //     */
    //
    //     $model = m::mock(Model::class);
    //     $repository = new EloquentRepository($model);
    //
    //     /*
    //     |------------------------------------------------------------
    //     | Expectation
    //     |------------------------------------------------------------
    //     */
    //
    //     $criteria = Criteria::create()
    //         ->groupBy('id');
    //
    //     /*
    //     |------------------------------------------------------------
    //     | Assertion
    //     |------------------------------------------------------------
    //     */
    //
    //     $model
    //         ->shouldReceive('groupBy')->with('id')->once()->andReturnSelf()
    //         ->shouldReceive('get')->once();
    //     $repository->findBy($criteria);
    // }

    public function testFindByCriteriaOrderBy()
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
        ];
        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->orderBy('age', 'desc')
            ->orderBy('id', 'asc');

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $model->shouldReceive('sort')->with(m::type(Closure::class))->once()->andReturnUsing(function ($callback) use (&$data) {
            uasort($data, $callback);

            $this->assertEquals([
                ['id' => 3, 'name' => 'Hugo', 'age' => '55'],
                ['id' => 2, 'name' => 'Angus', 'age' => '25'],
                ['id' => 5, 'name' => 'Mark', 'age' => '25'],
                ['id' => 1, 'name' => 'Pascal', 'age' => '15'],
            ], array_values($data));
        });
        $repository->findBy($criteria);
    }

    public function testFindByCriteriaWith()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

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

        $repository->findBy($criteria);
    }

    public function testFindByCriteriaJoin()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

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

        $repository->findBy($criteria);
    }

    public function testFindByCriteriaSelect()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

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

        $repository->findBy($criteria);
    }

    // public function testFindByCriteriaSelectExpression()
    // {
    //     /*
    //     |------------------------------------------------------------
    //     | Set
    //     |------------------------------------------------------------
    //     */
    //
    //     $model = m::mock(Model::class);
    //     $repository = new EloquentRepository($model);
    //
    //     /*
    //     |------------------------------------------------------------
    //     | Expectation
    //     |------------------------------------------------------------
    //     */
    //
    //     $criteria = Criteria::create()
    //         ->select(Criteria::expr('id'));
    //
    //     /*
    //     |------------------------------------------------------------
    //     | Assertion
    //     |------------------------------------------------------------
    //     */
    //
    //     $model
    //         ->shouldReceive('select')->with(m::type(Expression::class))->once()->andReturnSelf()
    //         ->shouldReceive('get')->once();
    //     $repository->findBy($criteria);
    // }

    public function testFindByArray()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

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
            ->shouldReceive('filter')->once()->andReturnSelf()
            ->shouldReceive('where')->with('fuzz', 'buzz')->once()->andReturnSelf()
            ->shouldReceive('where')->with('hello', 'world')->once()->andReturnSelf();
        $repository->findBy($criteria);
    }

    public function testFindByCriteriaAndArray()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

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
            ->shouldReceive('filter')->once()->andReturnSelf()
            ->shouldReceive('filter')->once()->andReturnSelf();
        $repository->findBy($criteria);
    }
}
