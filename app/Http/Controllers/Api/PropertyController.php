<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PropertyRequest;
use App\Http\Resources\PropertyCollection;
use App\Http\Resources\PropertyResource;
use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PropertyController extends Controller
{
    //

    public function index(): JsonResponse
    {
        return response()->json([PropertyCollection::collection(Property::paginate(5))]);
    }

    public function store(PropertyRequest $request): JsonResponse
    {
        $property = Property::create($request->validated());

        return response()->json([
            'data' => new PropertyResource($property)
        ], Response::HTTP_CREATED);
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
