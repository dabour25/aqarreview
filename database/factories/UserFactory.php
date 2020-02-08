<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use App\Models\Ads;
use App\Models\Adspro;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

//For Test Mode Only !!!
$factory->define(Ads::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'price' => rand(0, 1000000),
        'description' => Str::random(15),
        'size' =>rand(0, 1000),
		'general_type' =>rand("sell", "rent"),
		'type' => rand(1,5),
		'floor' =>rand(0, 10),
		'rooms' =>rand(0, 10),
		'pathroom' =>rand(0, 10),
		'kitchen' =>rand(0, 10),
		'finish' =>rand(1, 3),
		'furniture' =>rand(1, 2),
		'parking' =>rand(1, 2),
		'address' => Str::random(30),
    ];
});

$factory->define(Adspro::class, function (Faker $faker) {
    return [
		'ad' => 1,
        'name' => $faker->name,
		'email' => $faker->unique()->safeEmail,
        'phone' => rand(0, 1000000),
        'email_show' => 1,
    ];
});