<?php

namespace Tests\Feature\Authentication;

use Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;


it('Register User', function () {

    $data = [
        'username' => fake()->name(),
        'email' => fake()->email(),
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'password' => 'RashForddd',
        'confirm_password' => 'RashForddd',
        'phone_number' => fake()->phoneNumber(),
        'is_landlord' => fake()->boolean(),
    ];

    $response = $this->postJson(route('register', $data));
    $data = $response->json('user');

    //Assertions
    $response->assertStatus(201);
    expect($response['message'])->toBe('User created successfully');
    expect($response->json('user'))->toBeArray();
    $this->assertDatabaseCount('users', 1);
    $this->assertCount(9, $data);

    //
    $this->assertDatabaseHas('users', [
        'username' => $data['username'],
        'email' => $data['email'],
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'phone_number' => $data['phone_number'],
        'is_landlord' => $data['is_landlord'],
    ]);
});
