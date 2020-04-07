<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;

$factory->define(\SIGA\Acl\Models\Role::class, function (Faker $faker) {
    return [
        'user_id' => null
    ];
});
