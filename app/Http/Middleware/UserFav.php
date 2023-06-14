<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserFav
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $user = $request->user();
        echo($user->id);
        $favourites = Favourite::where('user_id', '=', $user->id)->get();
        // echo($user);
    // dd($favourites);

        if ($favourites === null ) {
        return response()->json([
        'message' => 'You are not authorized to perform this action'
    ], Response::HTTP_UNAUTHORIZED);
} 
        return $next($request);
    }
}
