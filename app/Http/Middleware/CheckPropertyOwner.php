<?php

namespace App\Http\Middleware;

use App\Models\Property;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPropertyOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $propertyId =  $request->route()?->parameter('property');
        try {
            $userId = Property::findOrFail($propertyId)->user_id;
        } catch (\Throwable $th) {
            return response()->json([
                'Message' => 'Property not found',
            ], Response::HTTP_NOT_FOUND);
        }
        $authUserId = $request->user()?->id;


        if ($userId !== $authUserId) return response()->json([
            'message' => 'You are not authorized to perform this action'
        ], Response::HTTP_UNAUTHORIZED);

        return $next($request);
    }
}
