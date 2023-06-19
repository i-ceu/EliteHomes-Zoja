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
       try
       {
        $reviewId = $request->route('review') ?? $request->input('review');

        // Find the review
        $review = Review::find($reviewId);

        // Check if the review exists and the authenticated user owns it
        if (!$review || $review->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

       } return $next($request);
    }
}
