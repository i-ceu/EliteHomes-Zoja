<?php

namespace App\Http\Controllers;
use App\Models\Property;
use App\Models\Reviews;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the reviews.
     */
    public function index(Property $property)
    {
        // Get all reviews for the property
        $reviews = $property->reviews;

        // Return the reviews
        return response()->json($reviews, 200);
    }

    /**
     * Add a new review.
     */
    public function create(Request $request, Property $property)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            // Add other validation rules as per your requirements
        ]);

        // Create a new review for the property
        $review = $property->reviews()->create($validatedData);

        // Return the created review
        return response()->json($review, 201);
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, Property $property, Reviews $reviews)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            // Add other validation rules as per your requirements
        ]);

        // Update the review
        $review->update($validatedData);

        // Return the updated review
        return response()->json($review, 200);
    }

    /**
     * Delete the specified review from storage.
     */
    public function destroy(Reviews $reviews)
    {
        //Delete the review
        $review->delete();

        // Return a success response
        return response()->json(['message' => 'Review deleted successfully'], 200);
    }
}
