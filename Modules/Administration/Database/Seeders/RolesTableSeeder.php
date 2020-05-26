<?php

namespace Modules\Administration\Database\Seeders;

use Modules\Administration\Entities\Roles;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        factory(Roles::class)->state('super_admin')->create();
        factory(Roles::class)->state('moderator')->create();
    }
}
