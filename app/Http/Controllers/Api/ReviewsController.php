<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReviewsRequest;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ReviewsResource;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the reviews.
     */
    public function index(int $property): JsonResponse
    {
        try {
            $allReviews = Reviews::where('property_id', $property)->get();
            return response()->json([
                'message' => "Reviews showed successfully",
                'data' => ReviewsResource::collection($allReviews),
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "no reviews found",
                'status' => 404
            ], 404);
        }
    }

    public function store(ReviewsRequest $request): JsonResponse
    {

        // Create a new review
        $review = Reviews::create(array_merge($request->validated(), ['user_id' => auth()->user()->id]));

        return response()->json([
            'message' => 'Review added successfully',
            'data' => new ReviewsResource($review) 
        ], 201);
    }

    // Update a review
    public function update(Request $request, int $review): JsonResponse
    {
        try {
            //code...
            $review = Reviews::findOrFail($review);

            $review->update($request->all());

            return response()->json([
                'message' => 'Review updated successfully',
                'data' => new ReviewsResource($review) 
            ], 200);
        } catch (\Throwable $th) {

            return response()->json([
                'message' => "no reviews found",
                'status' => 404
            ], 404);
        }
    }

    // Delete a review
    public function destroy(int $reviewId): JsonResponse
    {
        // Find the review
        $review = Reviews::findOrFail($reviewId);


        // Delete the review
        $review->delete();

        return response()->json(['message' => 'Review deleted successfully'], 200);
    }
}
