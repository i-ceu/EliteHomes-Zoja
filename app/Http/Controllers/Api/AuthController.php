<?php

namespace App\Http\Controllers\Api;

use App\Events\UserSignup;
use App\Http\Controllers\Controller;
use App\Http\Requests\{forgetPasswordReques, SignupRequest, LoginRequest, passwordResetRequest};
use App\Mail\SendCodeResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\users;
use App\Http\Traits\ResponseTrait;
use App\Models\EmailVerification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\ResestCodePassword;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    use ResponseTrait;
    public function register(SignupRequest $request): JsonResponse
    {
        $user =User::create($request->validated());

        UserSignup::dispatch($user);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
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
          
        ];

        $user->full_name = $user->first_name . ' ' . $user->last_name; // @phpstan-ignore-line

        $token = $user->createToken("$user->full_name token")->accessToken;

        return response()->json([
            'message' => 'Login successful',
            'data' => $data,
            'token' => $token,
        ]);
    }   

    
    
    public function forgetPassword(forgetPasswordReques $request){
        // Delete all old code that user send before.
     ResestCodePassword::where('email', $request->email)->delete();
              // Generate random code

          $data['email'] = $request->email;
          $data['Token'] = rand(000, 999);
          $data['created'] = now();

          $code = ResestCodePassword::create($data);
        
          // Send email to user
    
          Mail::to($request->email)->send(new SendCodeResetPassword($data['Token']));
          return response(['message'=> trans('passwords.sent')],200);    
    }   
    
     
     // passwordReset
     
     
     public function passwordReset(passwordResetRequest $request)
     {
         $user = User::where('email', $request->email)->first();

         if (!$user) {
             return 'This user is not found';
         }
         $user->fill([
             'password' => Hash::make($request->password),
         ]);
         $user->save();
         DB::table('resetcodepassword')->
         where('email', $user->email)->
         delete();

         return response()->json([
           'message' => 'Password reset successful',
            'data' => [$user],
         ]);
         
     }
     
    //    logout
     
     public function logout(Request $request){
        Auth::logout();

         return response()->json([
     'message'=> 'You have successfully logged out',
             ],200);
    } 

   
}
