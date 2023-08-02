<?php

use App\Models\User;

it('Login User', function () {

    $user = User::factory()->create([
        'password' => 'RashForddd',
    ]);

    $data = [
        'email' => $user->email,
        'password' => 'RashForddd',
    ];

    $response = $this->postJson(route('login', $data));

    $response->assertStatus(200);
    expect($response['message'])->toBe('Login successful');
    $response->assertJson(['token' => true]);
});

