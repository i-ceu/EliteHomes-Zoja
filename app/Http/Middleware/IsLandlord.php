<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsLandlord
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!$user?->is_landlord) {
            return response()->json([
                'Message' => 'You are not authorized to access this route'
            ], Response::HTTP_UNAUTHORIZED);
        } else {
            return $next($request);
        }
    }
}
