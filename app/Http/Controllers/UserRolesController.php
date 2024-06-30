<?php

namespace App\Http\Controllers;

use App\Models\UserRoles;
use App\Http\Requests\StoreUserRolesRequest;
use App\Http\Requests\UpdateUserRolesRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class UserRolesController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();
        $userRole = DB::table('user_roles')
            ->where('user_id', $userId)
            ->first();

        // Adding detailed logging to see what's retrieved
        // Log::info('User Role:', ['role' => $userRole]);

        $roleId = optional($userRole)->role_id;
        $isAdmin = ($roleId === 1);

        return Inertia::render('Dashboard', [
            'isAdmin' => $isAdmin,
            'roleId' => $roleId,
            'page_name' => 'Dashboard',
        ]);
    }

    public function viewService()
    {
        return Inertia::render('Service/View', [
            'page_name' => 'Services',
        ]);
    }

    public function createService()
    {
        return Inertia::render('Service/Create');
    }
}
