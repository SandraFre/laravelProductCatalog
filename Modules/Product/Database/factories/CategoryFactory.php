<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

namespace Modules\Product\Database\factories;

use Modules\Product\Entities\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'title'=>$faker->title,
        'slug'=>$faker->unique()->slug(1),
        'active'=>$faker->boolean,
    ];
});

$factory->state(Category::class, 'all', function(Faker $faker){
    return[
        'title'=> 'All',
        'slug' => 'all',
    ];
});

$factory->state(Category::class, 'newest', function(Faker $faker){
    return[
        'title'=> 'Newest',
        'slug' => 'newest',
    ];
});

$factory->state(Category::class, 'most_seen', function(Faker $faker){
    return[
        'title'=> 'Most seen',
        'slug' => 'most-seen',
    ];
});
