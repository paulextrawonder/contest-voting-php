<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Votes;
use Faker\Generator as Faker;

$factory->define(Votes::class, function (Faker $faker) {
    return [
    	'votes'				=> $faker->randomDigitNotNull,
    	'contestant_id'		=> $faker->unique()->numberBetween(1, App\Contestant::count()),
    ];
});
