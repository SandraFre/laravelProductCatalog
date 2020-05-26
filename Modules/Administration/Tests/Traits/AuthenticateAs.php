<?php

declare(strict_types = 1);

namespace Modules\Administration\Tests\Traits;

use Modules\Administration\Entities\Admin;
use Modules\Administration\Entities\Roles;
use Illuminate\Contracts\Auth\Authenticatable;

trait AuthenticateAs
{
    public function authenticateAs(
        array $roles = ['admin'],
        array $adminData = [],
        array $accessibleRoutes = []
    ): Authenticatable
    {
        $adminUser = factory(Admin::class)->create($adminData);

        $this->createRoles($adminUser, $roles, $accessibleRoutes);

        $this->actingAs($adminUser, 'admin');

        return $adminUser;
    }

    private function createRoles(Authenticatable $admin, array $roles, array $accessibleRoutes)
    {
        $createdRoles = collect();
        foreach ($roles as $role) {
            $createdRoles->offsetSet(
                $role,
                factory(Roles::class)->create([
                    'name' => $role,
                    'full_access' => ($role == 'admin'),
                    'accessible_routes' => ($role == 'admin') ? [] : $accessibleRoutes,
                ])
            );
        }

        $admin->roles()->sync($createdRoles->pluck('id'));
    }
}
