<?php

use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Model;
use Mockery as m;
use Recca0120\Repository\Criteria;
use Recca0120\Repository\EloquentRepository;

class EloquentRepositoryTest extends PHPUnit_Framework_TestCase
{
    use Laravel;

    public function setUp()
    {
        $app = $this->createApplication();
        $db = $this->createDatabase();
        Schema::create('users', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('password', 60);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('roles', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('user_roles', function ($table) {
            $table->integer('user_id');
            $table->integer('role_id');
        });

        $faker = FakerFactory::create();

        for ($i = 0; $i < 3; $i++) {
            User::create([
                'name'     => sprintf('%03d', $i + 1),
                'email'    => sprintf('%03d@test.com', $i + 1),
                'password' => $faker->text,
            ]);
        }

        Role::create([
            'name'        => 'superuser',
            'description' => 'superuser',
        ]);

        Role::create([
            'name'        => 'administrator',
            'description' => 'administrator',
        ]);

        User::find(1)->roles()->sync([1]);
    }

    public function tearDown()
    {
        m::close();
        Schema::drop('users');
    }

    public function test_repository_create()
    {
        $repository = new EloquentRepository(new User());
        $repositoryUser = $repository->create([
            'name'     => 'test9999',
            'email'    => 'test9999@test.com',
            'password' => str_random(30),
        ]);

        $modelUser = User::where('name', '=', 'test9999')->first();

        $this->assertSame($repositoryUser->id, $modelUser->id);
    }

    public function test_repository_find()
    {
        $repository = new EloquentRepository(new User());
        $repositoryUser = $repository->find(1);

        $modelUser = User::find(1);

        $this->assertSame($repositoryUser->id, $modelUser->id);
    }

    public function test_repository_update()
    {
        $repository = new EloquentRepository(new User());
        $repositoryUser = $repository->update([
            'password' => 'test_update',
        ], 2);

        $modelUser = User::find(2);

        $this->assertSame($repositoryUser->id, $modelUser->id);
        $this->assertSame($modelUser->password, 'test_update');
    }

    public function test_repository_delete()
    {
        $counter = User::count();
        $repository = new EloquentRepository(new User());

        $this->assertTrue($repository->delete(1));
        $this->assertSame(User::count(), $counter - 1);
    }

    public function test_repository_find_all()
    {
        $repository = new EloquentRepository(new User());
        $repositoryUsers = $repository->findAll();
        $modelUsers = User::all();
        $this->assertSame($repositoryUsers->toArray(), $modelUsers->toArray());
    }

    public function test_find_by_criteria()
    {
        $repository = new EloquentRepository(new User());
        $criteria = (new Criteria())
            ->where('name', '0001')
            ->having('email', '=', '0001@test.com')
            ->groupBy('name');
        $repositoryUsers = $repository->findBy($criteria);

        $modelUsers = User::where('name', 'like', '0001')
            ->where('email', '0001@test.com')
            ->groupBy('name')
            ->get();

        $this->assertSame($repositoryUsers->toArray(), $modelUsers->toArray());
    }

    public function test_find_by_criteria_where()
    {
        $repository = new EloquentRepository(new User());
        $criteria = (new Criteria())
            ->where('name', '0001');
        $repositoryUsers = $repository->findBy($criteria);

        $modelUsers = User::where('name', '0001')
            ->get();

        $this->assertSame($repositoryUsers->toArray(), $modelUsers->toArray());
    }

    public function test_find_by_criteria_where_closure()
    {
        $repository = new EloquentRepository(new User());
        $criteria = (new Criteria())
            ->where(function ($criteria) {
                return $criteria->where('name', '0001');
            });
        $repositoryUsers = $repository->findBy($criteria);

        $modelUsers = User::where(function ($query) {
            return $query->where('name', '0001');
        })->get();

        $this->assertSame($repositoryUsers->toArray(), $modelUsers->toArray());
    }

    public function test_find_by_criteria_or_where()
    {
        $repository = new EloquentRepository(new User());
        $criteria = (new Criteria())
            ->where('name', '0001')
            ->orWhere('name', '0002');
        $repositoryUsers = $repository->findBy($criteria);

        $modelUsers = User::where('name', '0001')
            ->orWhere('name', '0002')
            ->get();

        $this->assertSame($repositoryUsers->toArray(), $modelUsers->toArray());
    }

    public function test_find_by_criteria_or_where_closure()
    {
        $repository = new EloquentRepository(new User());
        $criteria = (new Criteria())
            ->where(function ($criteria) {
                return $criteria->where('name', '0001')
                    ->orWhere('name', '0002');
            });
        $repositoryUsers = $repository->findBy($criteria);

        $modelUsers = User::where(function ($query) {
            return $query->where('name', '0001')
                    ->orWhere('name', '0002');
        })->get();

        $this->assertSame($repositoryUsers->toArray(), $modelUsers->toArray());
    }

    public function test_criteria_where_has()
    {
        $repository = new EloquentRepository(new User());
        $criteria = (new Criteria())
            ->whereHas('roles', function ($criteria) {
                return $criteria->where('id', '=', 1);
            });
        $repositoryUsers = $repository->findBy($criteria);

        $modelUsers = User::whereHas('roles', function ($query) {
            return $query->where('id', '=', 1);
        })
            ->get();

        $this->assertSame($repositoryUsers->toArray(), $modelUsers->toArray());
    }

    public function test_criteria_join()
    {
        $repository = new EloquentRepository(new User());
        $criteria = (new Criteria())
            ->join('user_roles', function ($criteria) {
                return $criteria->on('users.id', '=', 'user_roles.user_id');
            });
        $repositoryUsers = $repository->findBy($criteria);

        $modelUsers = User::join('user_roles', function ($query) {
            return $query->on('users.id', '=', 'user_roles.user_id');
        })
            ->get();

        $this->assertSame($repositoryUsers->toArray(), $modelUsers->toArray());
    }

    public function test_criteria_order_by()
    {
        $repository = new EloquentRepository(new User());
        $criteria = (new Criteria())
            ->orderBy('name', 'desc');
        $repositoryUsers = $repository->findBy($criteria);

        $modelUsers = User::orderBy('name', 'desc')
            ->get();

        $this->assertSame($repositoryUsers->toArray(), $modelUsers->toArray());
    }

    public function test_criteria_select()
    {
        $repository = new EloquentRepository(new User());
        $criteria = (new Criteria())
            ->select('name');
        $repositoryUsers = $repository->findBy($criteria);

        $modelUsers = User::select('name')
            ->get();

        $this->assertSame($repositoryUsers->toArray(), $modelUsers->toArray());
    }

    public function test_criteria_experssion()
    {
        $repository = new EloquentRepository(new User());
        $criteria = (new Criteria())
            ->select(Criteria::expr('REPLACE(name, "0001", "0003")'));
        $repositoryUsers = $repository->findBy($criteria);

        $modelUsers = User::select(DB::raw('REPLACE(name, "0001", "0003")'))
            ->get();

        $this->assertSame($repositoryUsers->toArray(), $modelUsers->toArray());
    }

    public function test_criteria_paginated()
    {
        $repository = new EloquentRepository(new User());
        $repositoryUsers = $repository->paginatedAll(15);

        $modelUsers = User::paginate(15);

        $this->assertSame($repositoryUsers->toArray(), $modelUsers->toArray());
    }

    public function test_criteria_with()
    {
        $repository = new EloquentRepository(new User());
        $criteria = (new Criteria())
            ->with('roles');
        $repositoryUsers = $repository->findBy($criteria);

        $modelUsers = User::with('roles')->get();

        $this->assertSame($repositoryUsers->toArray(), $modelUsers->toArray());
    }

    public function test_find_by_array()
    {
        $repository = new EloquentRepository(new User());
        $repositoryUsers = $repository->findBy([
            ['name', '=', '0002'],
            ['email', '=', '0002@test.com'],
        ]);

        $modelUsers = User::where('name', '0002')
            ->where('email', '0002@test.com')->get();

        $this->assertSame($repositoryUsers->toArray(), $modelUsers->toArray());
    }

    public function test_find_by_array_key()
    {
        $repository = new EloquentRepository(new User());
        $repositoryUsers = $repository->findBy([
                'name'  => '0002',
                'email' => '0002@test.com',
            ]);

        $modelUsers = User::where('name', '0002')
            ->where('email', '0002@test.com')->get();

        $this->assertSame($repositoryUsers->toArray(), $modelUsers->toArray());
    }

    public function test_custom_criteria()
    {
        $repository = new EloquentRepository(new User());
        $repositoryUsers = $repository->findBy(new CustomCriteria());

        $modelUsers = User::where('name', '0002')->get();

        $this->assertSame($repositoryUsers->toArray(), $modelUsers->toArray());
    }

    public function test_multiple_criteria()
    {
        $repository = new EloquentRepository(new User());
        $repositoryUsers = $repository->findBy([
            new CustomCriteria(),
            (new Criteria())->orderBy('name', 'desc'),
        ]);

        $modelUsers = User::where('name', '0002')
            ->orderBy('name', 'desc')->get();

        $this->assertSame($repositoryUsers->toArray(), $modelUsers->toArray());
    }
}

class CustomCriteria extends Criteria
{
    public function __construct()
    {
        $this->where('name', '0002');
    }
}

class User extends Model
{
    protected $fillable = [
        'name', 'email', 'password',
    ];

    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'user_roles',
            'role_id',
            'user_id'
        );
    }
}

class Role extends Model
{
    protected $fillable = [
        'name', 'description',
    ];

    public function users()
    {
        return $this->belongsToMany(
            self::class,
            'user_roles',
            'user_id',
            'role_id'
        );
    }
}

function dump()
{
    call_user_func_array('var_dump', func_get_args());
}
