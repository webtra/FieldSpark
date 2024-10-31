<?php

namespace App\Http\Controllers;

use App\Models\Crops;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CropsController extends Controller
{
    public function index()
    {
        $crops = Crops::all();
        $cropCount = Crops::count();

        return Inertia::render('Crops/Index', [
            'crops' => $crops,
            'cropCount' => $cropCount,
        ]);
    }
}
