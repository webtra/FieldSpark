<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function dashboard() {
        return Inertia::render('Dashboard');
    }
}
