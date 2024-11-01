<?php

namespace App\Http\Controllers;

use App\Mail\NewUserWelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Stringable;

class UsersController extends Controller
{


    public function index()
    {
        $users = User::all();
        $usersCount = User::count();

        return Inertia::render('Users/Index', [
            'users' => $users,
            'usersCount' => $usersCount,
            'pageTitle' => 'Users',
        ]);
    }

    public function edit(Request $request, $id)
    {
        // Define validation rules based on the fields provided in the request
        $rules = [];

        if ($request->has('role_id')) {
            $rules['role_id'] = 'required|integer|in:1,2,3';
        }

        if ($request->has(['first_name', 'last_name', 'email'])) {
            $rules['first_name'] = 'required|string|max:255';
            $rules['last_name'] = 'required|string|max:255';
            $rules['email'] = 'required|string|email|max:255|unique:users,email,' . $id;
        }

        // Validate only the fields that are provided in the request
        $request->validate($rules);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the user attributes conditionally
        if ($request->has('role_id')) {
            $user->role_id = $request->input('role_id');
        }

        if ($request->has('first_name') && $request->has('last_name') && $request->has('email')) {
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
        }

        $user->save();

        return response()->json(['message' => 'User updated successfully'], 200);
    }

    public function destroy($id)
    {
        try {
            // Find the user by ID
            $user = User::findOrFail($id);

            // Soft delete the user
            $user->delete();

            // Return a JSON response to the axios call
            return response()->json(['message' => 'User soft deleted successfully.'], 200);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error deleting user: " . $e->getMessage());

            // Return an error response
            return response()->json(['message' => 'Error deleting user.'], 500);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        // Create the new user
        $user = User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'password' => 123456,
        ]);

        // Send login prompt email
        Mail::to($user->email)->send(new NewUserWelcomeMail($user));

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }
}
