<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reviews;
use Symfony\Component\HttpFoundation\Response;

class ReviewsOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        $reviewId = $request->route('review') ?? $request->input('review');


        try {
            //code...
            $review = Reviews::findOrFail($reviewId);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Review not found'], 404);
            //throw $th;
        } // Find the review

        // Check if the review exists and the authenticated user owns it
        if (!$review || $review->user_id !== $request->user()?->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
