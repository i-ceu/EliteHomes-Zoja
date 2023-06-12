<?php

namespace App\Http\Services;

use Closure;
use App\Models\User;

class UserServices
{


    public function fetchAllUsers()
    {
        try {
            $users = User::all();

            return response()->json([
                'message' => 'Users found',
                'data' => $users,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Users not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function fetchUserById(string $id, Closure $next)
    {
        try {
            $user  = User::findOrFail($id);

            return response()->json([
                'message' => 'User found',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'User not found ',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public static function fetchUserByEmail(string $email, Closure $next)
    {
        try {
            $user  = User::where('email', $email)->firstOrFail();

            if (!$user) {
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            } else {
                return $next($user);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching user',
                'error' => $e->getMessage(),
            ], 404);
        }
    }
}
