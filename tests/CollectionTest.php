<?php

namespace Recca0120\Repository\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Recca0120\Repository\Collection;
use Illuminate\Database\Schema\Blueprint;
use Recca0120\Repository\EloquentRepository;

class CollectionTest extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    public function testFind()
    {
        $fakeModel = new FakeCollectionModel;
        $fakeRepository = new FakeCollectionRepository($fakeModel);

        $instance = $fakeRepository->find(1);
        $this->assertInstanceOf(FakeCollectionModel::class, $instance);
        $this->assertTrue($instance->exists);
    }
}

class FakeCollectionModel extends Collection
{
    protected $items = [
        ['id' => 1, 'foo' => 'bar'],
    ];

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

class FakeCollectionRepository extends EloquentRepository
{
}
