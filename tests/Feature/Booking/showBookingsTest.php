<?php

use App\Models\Booking;

it('user can show properties', function () {
    $user = actingAs();

    $booking = Booking::factory()->create();
    $id = $booking->id;


    $response = $this->getJson(route('show-booking', $id));
    $response->assertStatus(200);

    expect($response['status'])->toBeTruthy();
    expect($response['message'])->toBe("booking showed successfully");
});
