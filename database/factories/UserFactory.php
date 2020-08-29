<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Imanghafoori\MasterPass\Models\User;

$factory->define(User::class, function (Faker $faker, $parameters) {

    $password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password
    $password = !empty($parameters['password']) ? Hash::make($parameters['password']) : $password;

    return [
        'username' => $faker->unique()->userName,
        'password' => $password,
    ];
});
