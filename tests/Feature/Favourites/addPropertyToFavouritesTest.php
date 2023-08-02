<?php

use App\Models\Property;


it('user can add property to favourites', function () {
    $user = actingAs();

    $property = Property::factory()->create();
    $id = $property->id;


    $response = $this->postJson(route('favourite.store', $id));
    $response->assertStatus(200);

    // expect($response['status'])->toBeTruthy();
    expect($response['message'])->toBe("Property added to favourites");

    $this->assertTrue($user->favourites->contains($property));
});
