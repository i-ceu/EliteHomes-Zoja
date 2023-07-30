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
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;


class PropertyController extends Controller
{
    //

    public function index(): AnonymousResourceCollection
    {
        return PropertyResource::collection(Property::orderByDesc('id')->get());
    }

    public function store(PropertyRequest $request): JsonResponse
    {

        $property = Property::create($request->except(['property_plan_image_url', 'property_other_image_url']));

        if ($request->hasFile('property_plan_image_url')) {
            $property->addMediaFromRequest('property_plan_image_url')->toMediaCollection('floor_plans', 'floor_plans');
        }

        if ($request->hasFile('property_other_image_url')) {
            $property->addMultipleMediaFromRequest(['property_other_image_url'])->each->toMediaCollection('propertyPictures', 'property_images');
        }
        return response()->json([
            'data' => new PropertyResource($property)
        ], Response::HTTP_CREATED);
    }

    // public function userindex( Request $request, User $user):JsonResponse
    // {
    //     try {
    //         $userId = $request->user();
    //         // echo $userId->id;
    //         $property = Property::where('user_id', $userId->id)->get();
    //         // echo($property);
    //         return response()->json([
    //             'Message'=> 'User Property Found',
    //             'data'=> $property], Response::HTTP_OK);
    //     } 
    //     catch (\Throwable $th) {
    //         return response()->json([
    //             'Message' => 'This User has no Property',
    //         ], Response::HTTP_NOT_FOUND);
    //     }
        
    // }

    public function userindex(Request $request, string $id): JsonResponse
    {
        try {
            $user = $request->user();
            // echo $user->id;
            $property = Property::where('user_id', $user?->id)->get();
            // echo ($property);
            return response()->json([
                'Message' => 'User Properties Found',
                'data' =>  PropertyResource::collection($property)
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
            // echo $property;
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
            $property->update($request->except(['property_plan_image_url', 'property_other_image_url']));

            if ($request->hasFile('property_plan_image_url')) {
                $image = $property->getFirstMedia('floor_plans');
                $property->clearMediaCollection('floor_plans');
                $property->addMediaFromRequest('property_plan_image_url')->toMediaCollection('floor_plans', 'floor_plans');
                $property->save();
            };

            if ($request->hasFile('property_other_image_url')) {
                $image = $property->getMedia('property_images');
                $property->clearMediaCollection('propertyPictures');
                $property->addMultipleMediaFromRequest(['property_other_image_url'])->each->toMediaCollection('propertyPictures', 'property_images');
                $property->save();
            }

            return response()->json([
                'data' => new PropertyResource($property)
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'Message' => $th->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }
    public function getOwnerDetails(Property $property): JsonResponse
    {
        try {
            //"full_name" = $user->first_name '.' $user->last_name;
            $owner = $property->user;
            return response()->json([
                'message' => 'User details found',
                'first name' => $owner?->first_name,
                'last name' => $owner?->last_name,
                'phone number' => $owner?->phone_number,
                'email' => $owner?->email,

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
