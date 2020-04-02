<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminStoreRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $admins = Admin::query()->paginate();

        return view('admin.list', [
            'list' => $admins
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('admin.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreRequest $request): RedirectResponse
    {
        try {
            Admin::query()->create($request->getData());
        } catch (Exception $exception) {
            return redirect()->back()
                ->withInput()
                ->with('danger', $exception->getMessage());
        }

        return redirect()->route('admins.index')
            ->with('status', 'Admin created!');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return View
     */
    public function edit(Admin $admin): View
    {
        return view('admin.form', ['item' => $admin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateRequest $request, Admin $admin): RedirectResponse
    {
        $data = $request->getData();
        $admin->update($data);
        return redirect()->route('admins.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): RedirectResponse
    {
        Admin::query()
        ->where('id', '=', $id)
        ->delete();

        return redirect()->route('admins.index');
    }
}
