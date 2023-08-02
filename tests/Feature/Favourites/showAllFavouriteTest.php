<?php

use App\Models\User;
use App\Models\Property;


// it('user can add property to favourites', function () {
//     $user = actingAs();

//     $property = Property::factory()->create();
//     // $id = $property->id;


//     $response = $this->getJson(route('favourite.index', $user->id));
//     $response->assertStatus(200);

//     // expect($response['status'])->toBeTruthy();
//     expect($response['message'])->toBe("Favourite properties showed successfully");

//     $this->assertTrue($user->favourites->contains($property));
// });


it('Get favourites properties', function() {

    
    $user = User::factory()->create();
    $properties = Property::factory()->count(3)->create();
    $id = $user->id;

    // Authenticate the user
    $this->actingAs($user);

    // Favorite the properties
    foreach ($properties as $property) {
        $user->favourites()->attach($property);
    }

    // Send a GET request to get favorite properties
    $response = $this->getJson('favourite.index', $id);

    // Assert that the response is successful
    $response->assertStatus(200);
    expect($response['message'])->toBe("Favourite properties showed successfully");

    // Assert that the response contains the favorite properties
    $response->assertJson(['favouriteProperties' => $properties->toArray()]);

});