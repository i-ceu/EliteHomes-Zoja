<?php

namespace App\Http\Controllers\Api;

use App\Events\UserSignup;
use App\Http\Controllers\Controller;
use App\Http\Requests\{SignupRequest, LoginRequest};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    public function register(SignupRequest $request)
    {
        $user = User::create($request->validated());

        UserSignup::dispatch($user);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
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
            'profilePicture' => $user->profile_picture,
        ];

        $token = $user->createToken("$user->full_name token")->accessToken;

        return response()->json([
            'message' => 'Login successful',
            'data' => $data,
            'token' => $token,
        ]);
    }
}
