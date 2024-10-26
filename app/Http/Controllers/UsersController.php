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
    public function dashboard()
    {
        return Inertia::render('Dashboard');
    }

    public function index()
    {
        $users = User::all();
        $usersCount = User::count();

        return Inertia::render('Users/Index', [
            'users' => $users,
            'usersCount' => $usersCount,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|integer|in:1,2,3',
        ]);

        // Find the user by id and update the role_id
        $user = User::findOrFail($id);
        $user->role_id = $request->input('role_id');
        $user->save();

        return response()->json(['message' => 'Role updated successfully'], 200);
    }

    public function updateProfile(Request $request, $id)
    {
        // Validate incoming data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ]);

        // Find the user and update the data
        $user = User::findOrFail($id);
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
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
