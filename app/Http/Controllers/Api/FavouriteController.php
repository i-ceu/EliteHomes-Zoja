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

    public function index(Request $request, string $userId): JsonResponse
    {

        $auth = auth()->id();
        $user = User::find($auth);
        $favourites = $user->favourites;

        return response()->json([
            'favouriteProperties' => FavouriteResource::collection($favourites)
        ], 200);
    }


    public function store(Request $request, string $propertyId): JsonResponse
    {    
        
        try {

            $auth = auth()->id();
            
            $user = User::find($auth);
            $property = Property::find($propertyId);
            
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
                'error' => 'error adding property'
            ], 403);
        }
            
    }
        
    public function delete(Request $request, string $propertyId): JsonResponse
    {
       
        try {
            $auth = auth()->id();
            $user = User::find($auth);
            $property = Property::find($propertyId);
            
            $isExist = $user->favourites->contains($property->id);

            if($isExist) {
             $user->favourites()->detach($property->id);

            }
                return response()->json([
                    'message' => 'Property removed from favorites.'
                ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'error occurred while removing favourites.'
            ], 200);
        }
    }
}