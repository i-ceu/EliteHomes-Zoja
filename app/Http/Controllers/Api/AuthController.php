<?php

namespace App\Http\Controllers\Api;

use App\Events\UserSignup;
use App\Http\Controllers\Controller;
use App\Http\Requests\{SignupRequest, LoginRequest};
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    public function register(SignupRequest $request): JsonResponse
    {

        $user = User::create($request->validated());

        if ($request->hasFile('profile_picture')) {
            $user->addMediaFromRequest('profile_picture')->toMediaCollection('avatars', 'avatars');
        }

        UserSignup::dispatch($user);

        return response()->json([
            'message' => 'User created successfully',
            'user' => new UserResource($user),
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $data = [
            'userId' => $user->id,
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'profilePicture' =>  $user->getFirstMediaUrl('avatars'),
        ];

        $user->full_name = $user->first_name . ' ' . $user->last_name; // @phpstan-ignore-line

        $token = $user->createToken("$user->full_name token")->accessToken;

        return response()->json([
            'message' => 'Login successful',
            'data' => $data,
            'token' => $token,
        ]);
    }
}
