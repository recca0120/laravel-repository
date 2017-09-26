<?php

namespace Recca0120\Repository\Tests;

use Mockery as m;
use Faker\Generator;
use PHPUnit\Framework\TestCase;
use Recca0120\Repository\Sqlite;
use Faker\Factory as FakerFactory;
use Recca0120\Repository\Criteria;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Database\Schema\Blueprint;
use Recca0120\Repository\EloquentRepository;

class EloquentRepositoryTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $faker = FakerFactory::create();
        $factory = new Factory($faker);
        $factory->define(FakeModel::class, function (Generator $faker) {
            return [
                'foo' => $faker->name,
            ];
        });

        $factory->of(FakeModel::class)->times(50)->create();
    }

    protected function tearDown()
    {
        parent::tearDown();
        m::close();

        $fakeModel = new FakeModel();
        $fakeModel->schema()->dropIfExists($fakeModel->getTable());
    }

    public function testInstance()
    {
        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $fakeRepository = new FakeRepository($model);
        $this->assertInstanceOf('Recca0120\Repository\EloquentRepository', $fakeRepository);
    }

    public function testFind()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->find(1);
        $this->assertInstanceOf(FakeModel::class, $instance);
        $this->assertTrue($instance->exists);
    }

    public function testFindMany()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instances = $fakeRepository->findMany([1, 2]);
        $instances->each(function ($instance) {
            $this->assertInstanceOf(FakeModel::class, $instance);
            $this->assertTrue($instance->exists);
        });
    }

    public function testFindOrFail()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->findOrFail(1);
        $this->assertInstanceOf(FakeModel::class, $instance);
        $this->assertTrue($instance->exists);
    }

    public function testFindOrNew()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->findOrNew(1000000);
        $this->assertInstanceOf(FakeModel::class, $instance);
        $this->assertFalse($instance->exists);
    }

    public function testFirstOrNew()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->firstOrNew(['id' => 10000], ['foo' => 'bar']);
        $this->assertInstanceOf(FakeModel::class, $instance);
        $this->assertSame('bar', $instance->foo);
        $this->assertFalse($instance->exists);
    }

    public function testFirstOrCreate()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->firstOrCreate(['id' => 10000], ['foo' => 'bar']);
        $this->assertInstanceOf(FakeModel::class, $instance);
        $this->assertSame('bar', $instance->foo);
        $this->assertTrue($instance->exists);
    }

    public function testUpdateOrCreate()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->updateOrCreate(['id' => 1], ['foo' => 'bar']);
        $this->assertInstanceOf(FakeModel::class, $instance);
        $this->assertSame('bar', $instance->foo);
        $this->assertTrue($instance->exists);
    }

    public function testFirstOrFail()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->firstOrFail();
        $this->assertInstanceOf(FakeModel::class, $instance);
        $this->assertTrue($instance->exists);
    }

    public function testCreate()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->create(['foo' => 'bar']);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $instance);
        $this->assertSame('bar', $instance->foo);
        $this->assertTrue($instance->exists);
    }

    public function testForceCreate()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->forceCreate(['foo' => 'bar']);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $instance);
        $this->assertSame('bar', $instance->foo);
        $this->assertTrue($instance->exists);
    }

    public function testUpdate()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->update(1, ['id' => 50000, 'foo' => 'bar']);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $instance);
        $this->assertSame('bar', $instance->foo);
        $this->assertSame(1, $instance->id);
        $this->assertTrue($instance->exists);
    }

    public function testForceUpdate()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);
        $instance = $fakeRepository->forceUpdate(1, ['id' => 50000, 'foo' => 'bar']);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $instance);
        $this->assertSame('bar', $instance->foo);
        $this->assertSame(50000, $instance->id);
        $this->assertTrue($instance->exists);
    }

    public function testDelete()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);
        $this->assertTrue($fakeRepository->delete(1));
        $this->assertNull($fakeRepository->find(1));
    }

    public function testForceDelete()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);
        $this->assertTrue($fakeRepository->forceDelete(1));
    }

    public function testNewInstance()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->newInstance(['foo' => 'bar']);
        $this->assertInstanceOf(FakeModel::class, $instance);
        $this->assertSame('bar', $instance->foo);
        $this->assertFalse($instance->exists);
    }

    public function testMatching()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $this->assertSame(
            $fakeRepository->matching([
                Criteria::create()->whereIn('id', [5, 9]),
                Criteria::create()->orWhereIn('id', [1, 3]),
                Criteria::create()->orderBy('id'),
            ])
            ->get()
            ->toArray(),
            FakeModel::whereIn('id', [5, 9])->orWhereIn('id', [1, 3])->orderBY('id')->get()->toArray()
        );
    }

    public function testGet()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $this->assertSame(
            $fakeRepository->get([
                Criteria::create()->where(function ($query) {
                    $query->whereIn('id', [1, 3])
                        ->orWhereIn('id', [5, 9]);
                }),
                Criteria::create()->orderBy('id'),
            ])
            ->toArray(),
            FakeModel::whereIn('id', [5, 9])->orWhereIn('id', [1, 3])->orderBY('id')->get()->toArray()
        );
    }

    public function testChunk()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $fakeRepository->chunk(Criteria::create()->where('id', '>', Criteria::expr(0)), 10, function ($collection) {
            $this->assertSame(10, $collection->count());
        });
    }

    public function testEach()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $fakeRepository->each(Criteria::create()->where('id', '>', Criteria::raw(0)), function ($model) {
            $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $model);
        });
    }

    public function testFirst()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $model = $fakeRepository->first(Criteria::create()->where('id', '>', 0));
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $model);
    }

    public function testPaginate()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $paginate = $fakeRepository->paginate(Criteria::create()->where('id', '>', 0));

        $this->assertSame(1, $paginate->currentPage());
    }

    public function testSimplePaginate()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $paginate = $fakeRepository->simplePaginate(Criteria::create()->where('id', '>', 0));

        $this->assertSame(1, $paginate->currentPage());
    }

    public function testCount()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $this->assertSame($fakeRepository->count(Criteria::create()->where('id', '>', 0)), 50);
    }

    public function testMin()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $this->assertSame($fakeRepository->min(Criteria::create()->where('id', '>=', 10), 'id'), '10');
    }

    public function testMax()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $this->assertSame($fakeRepository->max(Criteria::create()->where('id', '<=', 10), 'id'), '10');
    }

    public function testSum()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $this->assertSame($fakeRepository->sum(Criteria::create()->whereBetween('id', [1, 10]), 'id'), '55');
    }

    public function testAverage()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $this->assertSame($fakeRepository->average(Criteria::create()->whereBetween('id', [1, 10]), 'id'), '5.5');
    }
}

class FakeModel extends Sqlite
{
    protected $table = 'fake_models';

    protected $fillable = [
        'foo',
    ];

    protected function createSchema(Blueprint $table)
    {
        $table->increments('id');
        $table->string('foo');
        $table->timestamps();
    }
}

class FakeRepository extends EloquentRepository
{
}
