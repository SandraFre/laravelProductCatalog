<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Modules\Administration\Entities\Roles;
use Faker\Generator as Faker;

$factory->define(Roles::class, function (Faker $faker) {
    return [
        'name'=>$faker->unique()->words(3, true),
        'full_access'=>$faker->boolean,
        'accessible_routes'=> [],
        'description'=>$faker->text,
    ];
});

$factory->state(Roles::class, 'super_admin', function (Faker $faker){
    return[
        'name'=>'Super Admin',
        'full_access'=> true,
        'description' => 'Has full access to all routes',
    ];
});

$factory->state(Roles::class, 'moderator', function (Faker $faker){
    return[
        'name'=>'Moderator',
        'full_access'=> false,
        'description' => 'Has limited access',
    ];
});

