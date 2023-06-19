<?php

namespace App\Http\Controllers\Api;

use App\Events\BookTour;
use App\Models\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;



class BookingController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingRequest $request): JsonResponse
    {
        $booking = Booking::create($request->validated());

        $property = Property::findOrFail($booking->property_id);
        $user = User::findOrFail($property->user_id);

        BookTour::dispatch($user, $property); // @phpstan-ignore-line

        return response()->json([
            'message' => "Booking uploaded",
            'data' => $booking,
            'status' => 201,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $booking): JsonResponse
    {
        try {
            $booking = Booking::findOrFail($booking);
            return response()->json([
                'message' => "booking showed successfully",
                'data' => new BookingResource($booking),
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "booking with this id not found ",
                'status' => 404
            ], Response::HTTP_NOT_FOUND);
        }
    }
    public function showAllPropertyEnquiries(int $property): JsonResponse
    {
        try {
            $allBookings = Booking::where('property_id', $property)->get();
            return response()->json([
                'message' => "bookings showed successfully",
                'data' => BookingResource::collection($allBookings),
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "booking with this id not found ",
                'status' => 404
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function showAllUserEnquiries(string $id): JsonResponse
    {
        try {
            $allBookings = Booking::where('sender_id', $id)->get();
            // ->through(fn ($booking) => new BookingResource($booking));
            // echo $allBookings;
            return response()->json([
                'message' => "bookings showed successfully",
                'data' => BookingResource::collection($allBookings),
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "booking with this id not found ",
                'status' => 404
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking): JsonResponse
    {
        $booking->delete();
        return response()->json([
            'message' => "Booking deleted successfully",
            'data' => $booking,
            'status' => 200
        ]);
    }
}
