<?php

namespace App\Http\Controllers\Api;

use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FavouriteRequest;
use App\Http\Resources\FavouriteResource;

class FavouriteController extends Controller
{

    public function index(Request $request): JsonResponse
     {

        try {
        
        $user = $request->user();
        $favourites = Favourite::where('user_id', '=', $user->id)->paginate(5);

        return response()->json([
            'message' => 'Favourite listed successfully',
            'data' => $favourites,
            'status' => 200
        ]);
       } catch(\Throwable $th) {
        return response()->json([
            'message' => 'You have no favourites',
            'status' => 200
        ]);
        }
    }


    public function store(FavouriteRequest $request): JsonResponse
    {
         
       $favourite = Favourite::firstOrCreate($request->validated());
        return response()->json([
            'message' => 'Products added to favorites.',
            'data' => $favourite,
            'status' => 200
        ]);
        
    }

    public function delete(int $id): JsonResponse
    {
        try {
            //code...

            $favourite = Favourite::findOrFail($id);
            $favourite->delete();
            

            return response()->json([
                'message' => "favourite deleted successfully",
                'data' => $favourite,
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "favourite was not found ",
                'status' => 404
            ]);
        }
    }   
}

