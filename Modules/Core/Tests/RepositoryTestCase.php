<?php

declare(strict_types=1);

namespace Modules\Core\Tests;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;


class RepositoryTestCase extends TestCase
{
    protected $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = $this->app->make(Factory::class);

        $this->migrate();
    }

    protected function tearDown(): void
    {
        $this->dropTable();

        parent::tearDown();
    }

    private function migrate(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('role_id')->nullable();
            $table->rememberToken();
        });
    }

    private function dropTable(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
}
