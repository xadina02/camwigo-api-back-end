<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index(Request $request) 
    {
        $allUsers = User::whereDoesntHave('roles', function($query) {
            $query->where('name', 'admin');
        })->get();
        
        return view('admin.user', compact('allUsers'));
    }

    public function show($id) 
    {
        $user = User::find($id);

        // return data with a view
        return view('admin.user-details', compact('user'));
    }

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
            
            return redirect()->back()->with('success', 'User registered successfully');
        }

        if(!$user->hasRole($role))
        {
            $user->assignRole($role);
        }

        return redirect()->back()->with('error', 'The user already exists');
    }

    /**
     * Updating passenger user-details
     */
    public function update(UpdateUserRequest $request, $id)
    {
        logger('In user update method', $request->all());
        $validated = $request->validated();
        logger('In user update method', $validated);

        $current_timestamp = Carbon::now();
        $validated['updated_at'] = $current_timestamp;

        $user = User::find($id);

        if($user) 
        {
            logger('User found');
            $user->update($validated);
            logger('Details updated successfully');

            return redirect()->back()->with('success', 'User details updated successfully');
        }

        return redirect()->back()->with('error', 'User Not Found');
    }

    public function destroy($id) 
    {
        $user = User::find($id);

        if($user) 
        {
            $user->delete();
            return redirect()->back()->with('success', 'Account has been deleted');
        }
        return redirect()->back()->with('error', 'Account was not found');
    }
}
