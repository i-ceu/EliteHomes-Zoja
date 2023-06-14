# ELITE HOMES API Documentation

## USER ROUTES

### Register a New User

-   URL: /api/v1/login
```
-   data : {
        "email": "user@mail.com",
        "password":"password"
           }
 ```
-   Method: POST
-   Description: Register a new user in the system.

### User Login

-   URL: /api/v1/register
```
-   data : {
       "username":"tester",
       "first_name":"john",
       "last_name":"doe",
       "email":"john@mail.com",
       "password":"password",
       "confirm_password":"password",
       "phone_number":"phoneNumber",
        "is_landlord": 0
           }
```
-   Method: POST
-   Description: User login to authenticate and obtain an access token.

### Get User Details

-   URL: /api/user
-   Method: GET
-   Description: Get the authenticated user's details.

### Update User Details

-   URL: /api/user
-   Method: PUT
-   Description: Update the authenticated user's details.

### Delete User Account

-   URL: /api/user
-   Method: DELETE
-   Description: Delete the authenticated user's account.

## ADMIN ROUTES

### Get All Users

-   URL: /api/admin/users
-   Method: GET
-   Description: Get all users (admin only).

### Get Specific User

-   URL: /api/admin/users/{id}
-   Method: GET
-   Description: Get a specific user by ID (admin only).

### Update User Details

-   URL: /api/admin/users/{id}
    -Method: PUT
-   Description: Update a user's details (admin only).

### Delete User

-   URL: /api/admin/users/{id}
-   Method: DELETE
-   Description: Delete a user (admin only).

## PROPERTIES ROUTES

### Get All Properties

-   URL: /api/properties
-   Method: GET
-   Description: Get all properties.

### Get Specific Property

-   URL: /api/properties/{id}
-   Method: GET
-   Description: Get a specific property by ID.

### Create New Property

-   URL: /api/properties
-   Method: POST
-   Description: Create a new property.

### Update Property Details

-   URL: /api/properties/{id}
-   Method: PUT
-   Description: Update a property's details.

### Delete Property

-   URL: /api/properties/{id}
-   Method: DELETE
-   Description: Delete a property.

### Get Property Photos

-   URL: /api/properties/{id}/photos
-   Method: GET
-   Description: Get all photos of a specific property.

### Upload Property Photo

-   URL: /api/properties/{id}/photos
-   Method: POST
-   Description: Upload a photo for a specific property.

### Delete Property Photo

-   URL: /api/properties/{id}/photos/{photoId}
-   Method: DELETE
-   Description: Delete a photo of a specific property.

## LANDLORD ROUTES

### Inquiries Routes

### Get All Inquiries for a Specific Property

-   URL: /api/landlord/properties/{id}/inquiries
-   Method: GET
-   Description: Get all inquiries for a specific property.

### Get All Inquiries for Authenticated Landlord's Properties

-   URL: /api/landlord/inquiries
-   Method: GET
-   Description: Get all inquiries for the authenticated landlord's properties.

### Respond to a Specific Inquiry for a Property

-   URL: /api/landlord/properties/{id}/inquiries/{inquiryId}/respond
-   Method: POST
-   Description: Respond to a specific inquiry for a property.

### Bookings Routes

-   Get All Bookings for a Specific Property
-   URL: /api/landlord/properties/{id}/bookings
-   Method: GET
-   Description: Get all bookings for a specific property.

### Get All Bookings for Authenticated Landlord's Properties

-   URL: /api/landlord/bookings
-   Method: GET
-   Description: Get all bookings for the authenticated landlord's properties.

### Confirm a Specific Booking for a Property

-   URL: /api/landlord/properties/{id}/bookings/{bookingId}/confirm
-   Method: POST
-   Description: Confirm a specific booking for a property.

### Reject a Specific Booking for a Property

-   URL: /api/landlord/properties/{id}/bookings/{bookingId}/reject
-   Method: POST
-   Description: Reject a specific booking for a property.

## SEARCH ROUTES

### Search for Properties Based on Criteria

-   URL: /api/search/properties
-   Method: GET
-   Description: Search for properties based on criteria such as location, price range, and property type.

### Search for Users Based on Criteria

-   URL: /api/search/users
-   Method: GET
-   Description: Search for users based on criteria such as name, email, and role.

## FAVOURITES ROUTES

### Add a Property to the User's Favorites List

-   URL: /api/favorites/properties/{id}
    -Method: POST
-   Description: Add a property to the user's favorites list.

### Remove a Property from the User's Favorites List

-   URL: /api/favorites/properties/{id}
-   Method: DELETE
-   Description: Remove a property from the user's favorites list.

### Get the List of Properties in the User's Favorites List

-   URL: /api/favorites/properties
-   Method: GET
-   Description: Get the list of properties in the user's favorites list.

### Reviews Routes

-   Add a Review for a Specific Property
-   URL: /api/reviews/properties/{id}
-   Method: POST
-   Description: Add a review for a specific property.

### Update a Review

-   URL: /api/reviews/{id}
-   Method: PUT
-   Description: Update a review.

### Delete a Review

-   URL: /api/reviews/{id}
-   Method: DELETE
-   Description: Delete a review.

### Get All Reviews for a Specific Property

-   URL: /api/reviews/properties/{id}
-   Method: GET
-   Description: Get all reviews for a specific property.
