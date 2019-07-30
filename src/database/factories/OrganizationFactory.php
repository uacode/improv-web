<?php

use App\Orm\Production;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Orm\Organization::class, function (Faker $faker) {
    $user = factory(User::class)->create();
    if ($user === null) {
        $user = factory(User::class)->create();
    }
    return [
        'name' => $faker->sentence(3),
        'description' => $faker->sentence(30),
        'creator_id' => $user->id,
        'is_public' => true,
        'email' => $faker->email,
        'homepage_url'=>$faker->url,
        'facebook_url'=>$faker->url
    ];
});
