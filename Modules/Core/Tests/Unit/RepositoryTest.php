<?php

namespace Modules\Core\Tests\Unit;

use Faker\Generator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Modules\Core\Repositories\Repository;
use Modules\Core\Tests\RepositoryTestCase;

class RepositoryTest extends RepositoryTestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory->define(User::class, function (Generator $faker) {
            static $password;

            return [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => $password ?: $password = bcrypt('secret'),
                'remember_token' => $faker->randomDigitNotNull,
                'role_id' => null,
            ];
        });

        $this->factory->define(Role::class, function (Generator $faker) {
            return [
                'name' => $faker->name,
            ];
        });
    }

    /**
     * @group repository
     */
    public function testmodelMethodReturnBinnedModelClass(): void
    {
        $this->assertEquals(User::class, $this->getTestClassInstance()->model());
    }

    private function getTestClassInstance(): RepositoryFake
    {
        return $this->app->make(RepositoryFake::class);
    }

    /**
     * @group repository
     */
    public function testAllReturnCollectionInstance(): void
    {
        $this->assertInstanceOf(
            Collection::class,
            $this->getTestClassInstance()->all()
        );
    }

    /**
     * @group repository
     */
    public function testAllReturnSelectedColumns(): void
    {
        $count = mt_rand(2, 10);
        $i = 0;

        $users = factory(User::class, $count)->create();
        $testRepository = $this->getTestClassInstance();

        $this->assertCount($count, $testRepository->all());

        $testRepository->all()->each(function (User $user) use ($users, &$i) {
            $factoryUser = $users->get($i++);

            foreach (array_keys($user->getAttributes()) as $attribute) {
                $this->assertEquals($factoryUser->$attribute, $user->$attribute);
            }
        });

        $i = 0;
        $testRepository->all(['name'])->each(function (User $user) use ($users, &$i) {
            $factoryUser = $users->get($i++);

            $this->assertEquals($factoryUser->name, $user->name);
            $this->assertEquals(['name'], array_keys($user->getAttributes()));
        });
    }
}



class User extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}

class Role extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];
}

class RepositoryFake extends Repository
{
    public function model(): string
    {
        return User::class;
    }
}
