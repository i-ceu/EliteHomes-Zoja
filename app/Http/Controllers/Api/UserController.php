<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
// use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    // Display a list of users
    public function index(): JsonResponse
    {
        $users = User::latest()->paginate(10)->through(fn ($user) => new UserResource($user));

        return response()->json([
            'message' => 'Users retrieved successfully',
            'users' => $users
        ], Response::HTTP_OK);
    }

    //Display a specific user
    public function show(string $user): JsonResponse
    {
        try {

            $user = User::findOrFail($user);

            return response()->json([
                'Message' => 'User retrieved successfully',
                'data' => new UserResource($user),
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw Error;

            return response()->json([
                'Message' => 'User not found',

            ],  Response::HTTP_NOT_FOUND);
        }
    }



    public function update(Request $request, string $user): JsonResponse
    {
        try {
            //code...
            $user = User::findOrFail($user);

            $user->update($request->all());

            if ($request->hasFile('profile_picture')) {
                $image = $user->getFirstMedia('profile_picture');
                $user->clearMediaCollection('profile_picture');
                $user->addMediaFromRequest('profile_picture')->toMediaCollection('avatars', 'avatars');
                $user->save();
            };

            return response()->json([
                'Message' => 'User updated successfully',
                'data' => new UserResource($user),
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'Message' => 'User not found',

            ],  Response::HTTP_NOT_FOUND);
        }
    }


    public function destroy(string $user): JsonResponse
    {
        try {
            //code...
            $user = User::findOrFail($user);
            $user->delete();

            return response()->json([
                'message' => "user delete successfully",
                'data' => new UserResource($user),
                'status' => 200
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => "user was not found ",
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
