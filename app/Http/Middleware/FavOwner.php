<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FavOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    
    // $favouriteId = $request->route('favourite');
     try {
        $favouriteId = $request->route('favourite');
        $auth = auth()->id();
        $fav = Favourite::where('id', $favouriteId)
                  ->where('user_id', $auth)->exists();
                  
                // $fav = Favourite::where('id', $favouriteId)
                //   ->where('user_id', $auth);

                  dd($fav);
    if ($fav == 0) 
        return response()->json([
        'message' => 'You are not authorized to perform this action'
    ], Response::HTTP_UNAUTHORIZED);
     } catch(\Throwable $th) {

     }
    return $next($request);
    }
}



// namespace App\Http\Middleware;

// use App\Models\Property;
// use Closure;
// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;

// class FavOwner
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
//      */
//     public function handle(Request $request, Closure $next): Response
//     {
//         $propertyId =  $request->route()->parameter('favourite');
//         try {
//             $userId = Favourite::findOrFail($propertyId)->user_id;
//         } catch (\Throwable $th) {
//             return response()->json([
//                 'Message' => 'Property not found',
//             ], Response::HTTP_NOT_FOUND);
//         }
//         $authUserId = $request->user()->id;


//         if ($userId !== $authUserId) return response()->json([
//             'message' => 'You are not authorized to perform this action'
//         ], Response::HTTP_UNAUTHORIZED);

//         return $next($request);
//     }
// }
