<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use Illuminate\Http\JsonResponse;


class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     echo 'beans';
    //     echo $request->user()->id;
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingRequest $request): JsonResponse
    {
        $booking = Booking::create($request->validated());

        //todo 
        //send mail to owner
        //get landlord object from request
        //get email and send mail


        return response()->json([
            'message' => "Booking uploaded",
            'data' => $booking,
            'status' => 201,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $booking): JsonResponse
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
            ]);
        }
    }
    public function showAllPropertyBookings(int $property): JsonResponse
    {
        try {
            $booking = Booking::find($property);
            return response()->json([
                'message' => "bookings showed successfully",
                'data' => new BookingResource($booking),
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "booking with this id not found ",
                'status' => 404
            ]);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, int $booking)
    // {
    //     // no update required
    // }

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
