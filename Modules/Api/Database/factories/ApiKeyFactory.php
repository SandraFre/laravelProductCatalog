<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Api\Entities\ApiKey;

$factory->define(ApiKey::class, function (Faker $faker) {
    return [
        'title'=> $faker->title,
        'app_key'=>$faker->unique()->uuid,
        'active' => $faker->boolean,
    ];
});
