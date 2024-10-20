<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

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

    public function destroy($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Soft delete the user
        $user->delete();

        // Return a JSON response to the axios call
        return response()->json(['message' => 'User soft deleted successfully.']);
    }
}
