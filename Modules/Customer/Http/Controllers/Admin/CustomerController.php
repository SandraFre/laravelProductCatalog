<?php

declare(strict_types=1);

namespace Modules\Customer\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Customer\Http\Requests\Admin\CustomerStoreRequest;
use Modules\Customer\Http\Requests\Admin\CustomerUpdateRequest;
use App\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 */
class CustomerController extends Controller
{

    public function index(): View
    {
        $users = User::query()->paginate();

        return view('customer::customer.list', ['list' => $users]);
    }

    public function create(): View
    {
        return view('customer::customer.form');
    }

    public function store(CustomerStoreRequest $request): RedirectResponse
    {
        try {
            User::query()->create($request->getData());

            return redirect()->route('customers.index')
                ->with('status', 'Customer created.');
        } catch (Exception $exception) {
            return redirect()->back()->withInput()
                ->with('danger', $exception->getMessage());
        }
    }

    public function show(User $customer): View
    {
        return view('customer::customer.view', [
            'item' => $customer,
        ]);
    }

    public function edit(User $customer): View
    {
        return view('customer::customer.form', ['customer' => $customer]);
    }

    /**
     * @param CustomerUpdateRequest $request
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function update(CustomerUpdateRequest $request, User $customer): RedirectResponse
    {
        try {
            $customer->name = $request->getName();
            $customer->email = $request->getEmail();

            $password = $request->getHashPassword();
            if (!empty($password)) {
                $customer->password = $password;
            }


            $customer->save();

            return redirect()->route('customers.me')
                ->with('status', 'Info updated successfully!');
        } catch (Exception $exception) {
            return redirect()->back()->withInput()
                ->with('danger', $exception->getMessage());
        }
    }

    public function destroy(User $customer): RedirectResponse
    {
        try {
            $customer->delete();

            return redirect()->route('customers.index')
                ->with('status', 'Customer deleted!');
        } catch (Exception $exception) {
            return redirect()->back()
                ->with('danger', $exception->getMessage());
        }
    }
}
