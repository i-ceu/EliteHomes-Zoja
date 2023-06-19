<?php

namespace App\Http\Controllers;
use App\Models\Property;
use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReviewsRequest;
use App\Http\Resources\ReviewsResource;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the reviews.
     */
    public function index(Request $request)
    {
        // Get all reviews for the property
        $review = $property->review;

        // Return the reviews
        return response()->json($review, 200);
    }

    public function store(Request $request, $propertyId)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string',
        ]);

        // Create a new review
        $review = new Reviews;
        $review->property_id = $propertyId;
        $review->user_id = auth()->id(); // Assuming you have authentication set up
        $review->rating = $validatedData['rating'];
        $review->comment = $validatedData['comment'];
        $review->save();

        return response()->json(['message' => 'Review added successfully'], 201);
    }

    // Update a review
    public function update(Request $request, $reviewId)
    {
        // Find the review
        $review = Reviews::findOrFail($reviewId);

        $validatedData = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string',
        ]);

        // Update the review
        $review->rating = $validatedData['rating'];
        $review->comment = $validatedData['comment'];
        $review->save();

        return response()->json(['message' => 'Review updated successfully'], 200);
    }

    // Delete a review
    public function destroy($reviewId)
    {
        // Find the review
        $review = Reviews::findOrFail($reviewId);

        // Authorize the user to delete the review if needed
        // Add your authorization logic here, e.g., checking if the authenticated user owns the review

        // Delete the review
        $review->delete();

        return response()->json(['message' => 'Review deleted successfully'], 200);
    }
}
