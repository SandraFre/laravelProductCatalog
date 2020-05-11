<?php

declare(strict_types=1);

namespace  Modules\Customer\Services;

use Modules\Customer\DTO\CustomerFullDTO;
use App\User;
use Modules\Customer\Exceptions\CustomerException;
use Modules\Customer\Repositories\CustomerRepository;

class CustomerService
{
    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getMyInfoAPi(): CustomerFullDTO
    {
        $customer = $this->getAuthUser();

        return new CustomerFullDTO($customer);
    }

    public function updateMyInfoApi(array $data): void
    {
        $customer = $this->getAuthUser();

        $this->updateInfo($data, $customer->id);
    }

    public function updateInfo(array $data, int $id): int
    {
        return $this->customerRepository->update($data, $id);
    }

    private function getAuthUser(): User
    {
        /** @var User $customer */
        $customer = auth()->user();

        if (!$customer instanceof User) {
            throw CustomerException::noCustomer();
        }

        return $customer;
    }

    public function deleteMe(): void
    {
        $customer = $this->getAuthUser();

        $this->customerRepository->delete($customer->id);
    }
}
