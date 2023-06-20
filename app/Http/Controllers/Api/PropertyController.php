<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PropertyRequest;
use App\Http\Resources\PropertyCollection;
use App\Http\Resources\PropertyResource;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PropertyController extends Controller
{
    //

    public function index()
    {
        return PropertyResource::collection(Property::all());
    }

    public function store(PropertyRequest $request): JsonResponse
    {
        $property = Property::create($request->validated());

        return response()->json([
            'data' => new PropertyResource($property)
        ], Response::HTTP_CREATED);
    }

    public function userindex(Request $request, User $user): JsonResponse
    {
        try {
            $user = $request->user();
            // echo $userId->id;
            $property = Property::where('user_id', $user->id)->get();
            // echo($property);
            return response()->json([
                'Message' => 'User Property Found',
                'data' => PropertyCollection::collection($property)
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'Message' => 'This User has no Property',
            ], Response::HTTP_NOT_FOUND);
        }
    }
    public function show(int $property): JsonResponse
    {
        try {
            $property = Property::findOrFail($property);

            return response()->json([
                'Message' => 'Property Found',
                'data' => new PropertyResource($property),
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'Message' => 'Property not found',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, int $property): JsonResponse
    {
        try {
            $property = Property::findOrFail($property);

            $property->update($request->all());

            return response()->json([
                'data' => new PropertyResource($property)
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'Message' => 'Property not Found'
            ], Response::HTTP_NOT_FOUND);
        }
    }
    public function getOwnerDetails(Property $property)
    {
        try {
            //"full_name" = $user->first_name '.' $user->last_name;
            $owner = $property->user;
            return response()->json([
                'message' => 'User details found',
                'first name' => $owner->first_name,
                'last name' => $owner->last_name,
                'phone number' => $owner->phone_number,
                'email' => $owner->email,

            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'Message' => 'User details not Found'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy(int $property): JsonResponse
    {
        try {
            $property = Property::findOrFail($property);

            $property->delete();
            return response()->json([
                'Message' => 'Property deleted succesfully'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'Message' => 'Property not Found'
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
