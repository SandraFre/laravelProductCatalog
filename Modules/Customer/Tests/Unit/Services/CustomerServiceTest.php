<?php

namespace Modules\Customer\Tests\Unit\Services;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Customer\DTO\CustomerFullDTO;
use Modules\Customer\Exceptions\CustomerException;
use Modules\Customer\Services\CustomerService;

class CustomerServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group service
     * @group customer
     * @group customer_service
     */
    public function testSuccessGetMyInfoApi(): void
    {
        $customer = factory(User::class)->create();
        $this->actingAs($customer, 'api');

        $customerDTO = $this->getTestClassInstance()->getMyInfoAPi();

        $this->assertInstanceOf(CustomerFullDTO::class, $customerDTO);

        $this->assertEquals(new CustomerFullDTO($customer), $customerDTO);
    }

    /**
     * @group service
     * @group customer
     * @group customer_service
     */
    public function testThrowCustomerExceptionOnGetMyInfoApi(): void
    {
        $this->expectException(CustomerException::class);
        $this->expectExceptionMessage(CustomerException::noCustomer()->getMessage());

        $this->getTestClassInstance()->getMyInfoAPi();
    }

    /**
     * @group service
     * @group customer
     * @group customer_service
     */
    public function testUpdateMyInfoApi(): void
    {
        $updateData = [
            'name' => 'Josua',
        ];

        $customer = factory(User::class)->create([
            'name' => 'Tom',
        ]);

        $this->actingAs($customer, 'api');

        $result = $this->getTestClassInstance()->updateMyInfoApi($updateData);

        $this->assertEquals(1, $result);
    }

    /**
     * @group service
     * @group customer
     * @group customer_service
     */
    public function testUpdateInfo(): void
    {
        $updateData = [
            'name' => 'Josua',
        ];

        $customer = factory(User::class)->create([
            'name' => 'Tom',
        ]);

        $result = $this->getTestClassInstance()->updateInfo($updateData, $customer->id);

        $this->assertEquals(1, $result);
    }

    /**
     * @group service
     * @group customer
     * @group customer_service
     */
    public function testSuccessDeleteMe(): void
    {
        $customer = factory(User::class)->create();

        $this->actingAs($customer, 'api');

        $result = $this->getTestClassInstance()->deleteMe();

        $this->assertEquals(1, $result);
    }


    private function getTestClassInstance(): CustomerService
    {
        return $this->app->make(CustomerService::class);
    }
}
