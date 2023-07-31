<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FavouriteRequest;
use App\Http\Resources\FavouriteResource;

class FavouriteController extends Controller
{

    public function index(Request $request, string $userId)//: JsonResponse
    {

        $auth = auth()->id();
        $user = User::find($auth);
        $favourites = $user->favourites;

        return response()->json([
            'favouriteProperties' => $favourites
        ], 200);
    }


    public function store(Request $request): JsonResponse
    {    
        
        try {

            $propertyInput = $request->input('property_id');
            $auth = auth()->id();
            
            $user = User::find($auth);
            $property = Property::find($propertyInput);
            
            $isFavourited = $user->favourites->contains($property->id);

            if($isFavourited) {
                return response()->json([
                    'message' => 'property already exists in your favourite'
                ], 403);
            }
                $user->favourites()->attach($property->id);
                return response()->json([
                    'message' => 'Property added to favourites'
                ], 200);
            

        } catch(\Throwable $th) {
            // dd($isFavourited);
            return response()->json([
                'message' => 'property already exists in your favourite'
            ], 403);
        }
            
    }
        
    public function delete(Request $request, int $PropertyId): JsonResponse
    {
       
        
        $user = auth()->user();
        $property = Property::findOrFail($PropertyId);

        try {
            $detached = $user->favourites()->detach($property->id);

            if ($detached) {
                return response()->json(['message' => 'Property removed from favorites.'], 200);
            } else {
                return response()->json(['error' => 'Failed to remove property from favorites.'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while removing the property from favorites.'], 500);
        }
    }
}