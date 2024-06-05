<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Carbon\Carbon;

class AuthenticationController extends Controller
{
    /**
     * Registering new passenger-users
     */
    public function register(RegisterUserRequest $request) 
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();
        $role = Role::firstWhere('name', 'passenger');

        $query = User::query();

        if (isset($validated['NIN'])) {
            $query->orWhere('NIN', $validated['NIN']);
        }
        if (isset($validated['phone'])) {
            $query->orWhere('phone', $validated['phone']);
        }
        if (isset($validated['email'])) {
            $query->orWhere('email', $validated['email']);
        }

        // Order by the priority (NIN first, then phone, then email)
        $query->orderByRaw('NIN = ? DESC', [$validated['NIN'] ?? null])
            ->orderByRaw('phone = ? DESC', [$validated['phone'] ?? null])
            ->orderByRaw('email = ? DESC', [$validated['email'] ?? null]);

        // Get the first user that matches the highest priority condition
        $user = $query->first();

        if(!$user) 
        {
            $user = new User();

            $user->first_name = $validated['first_name'];
            $user->last_name = $validated['last_name'];
            $user->phone = $validated['phone'];
            $user->NIN = $validated['NIN'];
            $user->created_at = $current_timestamp;
            $user->updated_at = $current_timestamp;
            
            if(array_key_exists('email', $validated)) {
                $user->email = $validated['email'];
            }
            
            $user->assignRole($role);
            $user->save();

            $token = $user->createToken($user->NIN . 'AuthToken')->plainTextToken;
            return new UserResource($user, $token, 'Bearer');
        }

        if(!$user->hasRole($role))
        {
            $user->assignRole($role);
        }

        $token = $user->createToken($user->NIN . 'AuthToken')->plainTextToken;
        return new UserResource($user, $token, 'Bearer');
    }

    /**
     * Updating passenger user-details
     */
    public function update(UpdateUserRequest $request)
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();
        $validated['updated_at'] = $current_timestamp;
        $id = auth('sanctum')->user()->id;

        $user = User::find($id);

        if($user) 
        {
            $user->update($validated);

            return response()->json(['message' => 'User details updated successfully'], 200);
        }

        return response()->json(['message' => 'User not found'], 404);
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

        return response()->json(["message" => "logged out successfully"], 200);
    }

    public function destroy(Request $request) 
    {
        $user = Auth::user();

        if($user) 
        {
            $user->delete();
            return response()->json(["message" => "Account has been deleted"], 200);
        }
        return response()->json(["message" => "Account was not found"], 404);
    }
}
