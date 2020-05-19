<?php

namespace Modules\Customer\Tests\Feature\Http\Controllers\API;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group customer
     * @group api
     * @group customer_api
     */
    public function testShow(): void
    {
        $customer = factory(User::class)->create();

        $this->actingAs($customer, 'api');

        $response = $this->get(route('api.customer.show'), [
            'Accept' => 'application/json',
        ]);

        $response->assertOk();
    }

    /**
     * @group customer
     * @group api
     * @group customer_api
     */
    public function testFailUpdateValidation(): void
    {
        $customer = factory(User::class)->create();

        $this->actingAs($customer, 'api');

        $response = $this->put(route('api.customer.update'), [], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

    }

    /**
     * @group customer
     * @group api
     * @group customer_api
     */
    public function testSuccessUpdateValidation(): void
    {
        $customer = factory(User::class)->create();

        $this->actingAs($customer, 'api');

        $response = $this->put(route('api.customer.update'), [
            'first_name'=>$customer->name,
            'last_name' =>$customer->last_name,
            'email' => $customer->email,
            'mobile'=> $customer->mobile,
            'address'=> $customer->address,
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
    }

    /**
     * @group customer
     * @group api
     * @group customer_api
     */
    public function testDestroy(): void
    {
        $customer = factory(User::class)->create();

        $this->actingAs($customer, 'api');

        $response = $this->delete(route('api.customer.destroy'), [], [
            'Accept' => 'application/json',
        ]);

        $response->assertOk();
    }
}

