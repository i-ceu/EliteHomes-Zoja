<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PropertyRequest;
use App\Http\Resources\PropertyResource;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
        $property_other_image_url =[];
        $property_plan_image_url = "";
        if ($request->hasFile('property_plan_image_url')) {
            $property_plan_image_url = cloudinary()->upload($request->file('property_plan_image_url')->getRealPath())->getSecurePath();
        }

        if ($request->hasFile('property_other_image_url')) {
            foreach ($request->file('property_other_image_url') as $image) {
                $property_other_image_url[] = cloudinary()->upload($image->getRealPath())->getSecurePath();
            }
        }
        $property = Property::create(array_merge($request->validated(), [
            'property_other_image_url' => json_encode($property_other_image_url),
            'property_plan_image_url' => $property_plan_image_url,
            'user_id'=> auth()->user()->id
        ]));
        return response()->json([
            'data' => new PropertyResource($property)
        ], Response::HTTP_CREATED);
    }

    public function userindex(Request $request, User $user): JsonResponse
    {
        try {
            $userId = $request->user();
            // echo $userId->id;
            $property = Property::where('user_id', $userId->id)->get();
            // echo($property);
            return response()->json([
                'Message' => 'User Property Found',
                'data' => PropertyResource::collection($property)
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

            if ($request->hasFile('property_plan_image_url')) {
                if ($property->property_plan_image_url) {
                    deleteFromCloudinary($property->property_plan_image_url);

                }
                $property_plan_image_url = cloudinary()->upload($request->file('property_plan_image_url')->getRealPath())->getSecurePath();
            };

            if ($request->hasFile('property_other_image_url')) {
                foreach ($request->file('property_other_image_url') as $image) {
                    foreach (json_decode($property->property_other_image_url) as $propImage) {
                        if ($property->property_other_image_url) {
                            deleteFromCloudinary($propImage);
                        }
                    };
                    $property_other_image_url[] = cloudinary()->upload($image->getRealPath())->getSecurePath();
                }
            }

            $property->update(array_merge($request->all(), [
                'property_plan_image_url' => $property_plan_image_url,
                'property_other_image_url' => json_encode($property_other_image_url)
            ]));

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
            
            if ($property->property_plan_image_url) {
                deleteFromCloudinary($property->property_plan_image_url);
            }

            foreach (json_decode($property->property_other_image_url) as $propImage) {
                if ($property->property_other_image_url) {
                    deleteFromCloudinary($propImage);
                }
            };
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

function deleteFromCloudinary(string $url)
{
    $parts = explode('/', $url);
    $publicId = explode('.', $parts[7]);
    return cloudinary()->destroy($publicId);
}
