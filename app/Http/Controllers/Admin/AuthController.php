<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function getLoginPage() 
    {
        // return view(''); - admin login page
        return "Absolutely working";
    }

    public function login(LoginRequest $request) 
    {
        logger("In admin login method. The request: ", $request->all());
        $validated = $request->validated();
        logger("Validated fields: ", $validated);

        $user = User::where('email', $validated['email'])->first();

        if (!(auth('web')->attempt(['email' => $validated['email'], 'password' => $validated['password']], $request->remember))) 
        {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }

        $token = $user->createToken($user->NIN ?? $user->email . 'AuthToken')->plainTextToken;
        return new UserResource($user, $token, 'Bearer');
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
    }
}
