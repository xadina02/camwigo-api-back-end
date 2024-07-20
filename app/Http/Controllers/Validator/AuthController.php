<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getLoginPage() 
    {
        // return view(''); - admin login page
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request) 
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if($user->hasRole('admin'))
        {
            if ((Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $request->remember))) 
            {
                $token = $user->createToken($user->NIN ?? $user->email . 'AuthToken')->plainTextToken;
                // return new UserResource($user, $token, 'Bearer');
                return redirect()->route('homepage');
            }
        }

            return response()->json(['message' => 'Invalid admin email or password'], 401);
    }

    public function logout(Request $request) 
    {
        if ($request->user()) {
            $token = $request->user()->currentAccessToken();
            
            if ($token) {
                $token->delete();
                auth('web')->logout();
            } else {
                return response()->json(["message" => "Token not found"], 404);
            }
        }

        return response()->json(["message" => "logged out"], 200);
        // return redirect()->route('login', ['version'=>'v1', 'lang'=>'en']);
    }
}
