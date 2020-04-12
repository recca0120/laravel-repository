<?php

namespace Recca0120\Repository\Tests;

use Faker\Factory as FakerFactory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;
use PHPUnit\Framework\TestCase;
use Recca0120\Repository\Criteria;
use Recca0120\Repository\EloquentRepository;
use Recca0120\Repository\SqliteModel;

class EloquentRepositoryTest extends TestCase
{
    protected function setUp(): void
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

    protected function tearDown(): void
    {
        parent::tearDown();
        $fakeModel = new FakeModel();
        $fakeModel->truncate();
    }

    public function test_find()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->find(1);
        $this->assertInstanceOf(FakeModel::class, $instance);
        $this->assertTrue($instance->exists);
    }

    public function test_find_many()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instances = $fakeRepository->findMany([1, 2]);
        $instances->each(function ($instance) {
            $this->assertInstanceOf(FakeModel::class, $instance);
            $this->assertTrue($instance->exists);
        });
    }

    public function test_find_or_fail()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->findOrFail(1);
        $this->assertInstanceOf(FakeModel::class, $instance);
        $this->assertTrue($instance->exists);
    }

    public function test_find_or_new()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->findOrNew(1000000);
        $this->assertInstanceOf(FakeModel::class, $instance);
        $this->assertFalse($instance->exists);
    }

    public function test_first_or_new()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->firstOrNew(['id' => 10000], ['foo' => 'bar']);
        $this->assertInstanceOf(FakeModel::class, $instance);
        $this->assertSame('bar', $instance->foo);
        $this->assertFalse($instance->exists);
    }

    public function test_first_or_create()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->firstOrCreate(['id' => 10000], ['foo' => 'bar']);
        $this->assertInstanceOf(FakeModel::class, $instance);
        $this->assertSame('bar', $instance->foo);
        $this->assertTrue($instance->exists);
    }

    public function test_update_or_create()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->updateOrCreate(['id' => 1], ['foo' => 'bar']);
        $this->assertInstanceOf(FakeModel::class, $instance);
        $this->assertSame('bar', $instance->foo);
        $this->assertTrue($instance->exists);
    }

    public function test_first_or_fail()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $model = $fakeRepository->firstOrFail(Criteria::create()->where('id', '>', 0));
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $model);
    }

    public function test_create()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->create(['foo' => 'bar']);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $instance);
        $this->assertSame('bar', $instance->foo);
        $this->assertTrue($instance->exists);
    }

    public function test_force_create()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->forceCreate(['foo' => 'bar']);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $instance);
        $this->assertSame('bar', $instance->foo);
        $this->assertTrue($instance->exists);
    }

    public function test_update()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->update(1, ['id' => 50000, 'foo' => 'bar']);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $instance);
        $this->assertSame('bar', $instance->foo);
        $this->assertSame(1, $instance->id);
        $this->assertTrue($instance->exists);
    }

    public function test_force_update()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);
        $instance = $fakeRepository->forceUpdate(1, ['id' => 50000, 'foo' => 'bar']);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $instance);
        $this->assertSame('bar', $instance->foo);
        $this->assertSame(50000, $instance->id);
        $this->assertTrue($instance->exists);
    }

    public function test_delete()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);
        $this->assertTrue($fakeRepository->delete(1));
        $this->assertNull($fakeRepository->find(1));
    }

    public function test_restore()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $fakeRepository->delete(1);
        $this->assertNull($fakeRepository->find(1));

        $this->assertSame(1, $fakeRepository->get(Criteria::create()->whereIn('id', [1, 2]))->count());
        $this->assertSame(2, $fakeRepository->get(Criteria::create()->whereIn('id', [1, 2])->withTrashed())->count());
        $this->assertSame(1, $fakeRepository->get(Criteria::create()->whereIn('id', [1, 2])->onlyTrashed())->count());

        $fakeRepository->restore(1);
        $this->assertNotNull($fakeRepository->find(1));
    }

    public function test_force_delete()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);
        $this->assertTrue($fakeRepository->forceDelete(1));
    }

    public function test_new_instance()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $instance = $fakeRepository->newInstance(['foo' => 'bar']);
        $this->assertInstanceOf(FakeModel::class, $instance);
        $this->assertSame('bar', $instance->foo);
        $this->assertFalse($instance->exists);
    }

    public function test_matching()
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

    public function test_get()
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

    public function test_chunk()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $fakeRepository->chunk(Criteria::create()->where('id', '>', Criteria::expr(0)), 10, function ($collection) {
            $this->assertSame(10, $collection->count());
        });
    }

    public function test_each()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $fakeRepository->each(Criteria::create()->where('id', '>', Criteria::raw(0)), function ($model) {
            $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $model);
        });
    }

    public function test_first()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $model = $fakeRepository->first(Criteria::create()->where('id', '>', 0));
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $model);
    }

    public function test_paginate()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $paginate = $fakeRepository->paginate(Criteria::create()->where('id', '>', 0));

        $this->assertSame(1, $paginate->currentPage());
    }

    public function test_simple_paginate()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $paginate = $fakeRepository->simplePaginate(Criteria::create()->where('id', '>', 0));

        $this->assertSame(1, $paginate->currentPage());
    }

    public function test_count()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $this->assertSame($fakeRepository->count(Criteria::create()->where('id', '>', 0)), 50);
    }

    public function test_min()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $this->assertSame($fakeRepository->min(Criteria::create()->where('id', '>=', 10), 'id'), '10');
    }

    public function test_max()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $this->assertSame($fakeRepository->max(Criteria::create()->where('id', '<=', 10), 'id'), '10');
    }

    public function test_sum()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $this->assertSame($fakeRepository->sum(Criteria::create()->whereBetween('id', [1, 10]), 'id'), '55');
    }

    public function test_average()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $this->assertSame($fakeRepository->average(Criteria::create()->whereBetween('id', [1, 10]), 'id'), '5.5');
    }

    public function test_model_is_query()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository2($fakeModel);

        $this->assertSame($fakeRepository->average([], 'id'), '5.5');
    }

    public function test_get_query()
    {
        $fakeModel = new FakeModel;
        $fakeRepository = new FakeRepository($fakeModel);

        $this->assertEquals(
            $fakeRepository->getQuery([
                Criteria::create()->where(function ($query) {
                    $query->whereIn('id', [1, 3])
                        ->orWhereIn('id', [5, 9]);
                }),
                Criteria::create()->orderBy('id'),
            ])->get()->toArray(),
            FakeModel::whereIn('id', [5, 9])->orWhereIn('id', [1, 3])->orderBY('id')->getQuery()->get()->toArray()
        );
    }
}

class FakeModel extends SqliteModel
{
    use SoftDeletes;

    protected $table = 'fake_models';

    protected $fillable = [
        'foo',
    ];

    protected function createSchema(Blueprint $table)
    {
        $table->increments('id');
        $table->string('foo');
        $table->timestamps();
        $table->softDeletes();
    }
}

class FakeRepository extends EloquentRepository
{
}

class FakeRepository2 extends EloquentRepository
{
    public function __construct(Model $model)
    {
        $this->model = $model->whereBetween('id', [1, 10]);
    }
}
