<?php

declare(strict_types=1);

namespace Modules\Customer\Tests\Unit\Enum;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Customer\Enum\CustomerAuthLogTypeEnum;

class CustomerAuthLogTypeEnumTest extends TestCase
{
    /**
     * @group enum
     * @group customer
     * @group customer_enum
     */
    public function testLoggedIn(): void
    {
        $result = CustomerAuthLogTypeEnum::loggedIn();

        $this->assertInstanceOf(CustomerAuthLogTypeEnum::class, $result);

        $this ->assertEquals('logged_in', $result->id());
        $this ->assertEquals(__('Logged In'), $result->name());
        $this ->assertEquals('', $result->description());
    }

    /**
     * @group enum
     * @group customer
     * @group customer_enum
     */
    public function testLoggedOut(): void
    {
        $result = CustomerAuthLogTypeEnum::loggedOut();

        $this->assertInstanceOf(CustomerAuthLogTypeEnum::class, $result);

        $this ->assertEquals('logged_out', $result->id());
        $this ->assertEquals(__('Logged Out'), $result->name());
        $this ->assertEquals('', $result->description());
    }
}
