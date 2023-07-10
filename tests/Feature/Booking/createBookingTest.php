<?php

use App\Models\Property;

it('user can create a booking enquiry', function () {
    $user = actingAs();

    $property = Property::factory()->create();

    $data = [
        'name' => fake()->name(),
        'email' => fake()->email(),
        'message' => fake()->sentence(),
        'phone_number' => fake()->phoneNumber(),
        'sender_id' => $user?->id,
        'property_id' => $property->id,
    ];

    $response = $this->postJson(route('create-booking', $data));
    $response->assertStatus(200);

    $this->assertDatabaseCount('properties', 1);
    $this->assertDatabaseCount('bookings', 1);
    $this->assertDatabaseHas('bookings', [
        'name' => $data['name'],
        'email' => $data['email'],
        'message' => $data['message'],
        'phone_number' => $data['phone_number'],
        'sender_id' => $data['sender_id'],
        'property_id' => $data['property_id'],
    ]);

    expect($response['status'])->toBeTruthy();
    expect($response['message'])->toBe("Booking uploaded");
});
