<?php

namespace App\Http\Controllers;

use App\Models\Agrochemicals;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AgrochemicalsController extends Controller
{
    public function index()
    {
        // Eager load `cultivar` relationship to access cultivar names
        $agrochemicals = Agrochemicals::all();
        $agrochemicalsCount = Agrochemicals::count();

        return Inertia::render('Agrochemical/Index', [
            'agrochemicals' => $agrochemicals,
            'agrochemicalsCount' => $agrochemicalsCount,
            'pageTitle' => 'Agrochemicals',
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'recommended_dosage' => 'nullable|numeric',
            'description' => 'nullable|string',
            'category' => 'required|in:Herbicide,Pesticide,Fungicide,Fertilizer,Growth Regulator',
            'manufacturer' => 'nullable|string',
            'application_method' => 'nullable|in:Spray,Granular,Drip,Foliar',
            'toxicity_level' => 'nullable|in:Low,Medium,High',
            'restricted_use' => 'nullable|boolean',
            'recommended_application_frequency' => 'nullable|string',
            'reentry_interval' => 'nullable|integer',
            'pre_harvest_interval' => 'nullable|integer',
            'safety_precautions' => 'nullable|string',
            'mixing_compatibility' => 'nullable|string',
        ]);

        // Create the new crop entry
        $agrochemical = Agrochemicals::create($validatedData);

        return response()->json(['message' => 'Agrochemical created successfully', 'agrochemical' => $agrochemical], 201);
    }

    public function destroy(Agrochemicals $agrochemicals)
    {
        $agrochemicals->delete();

        return response()->json(['message' => 'Agrochemical deleted successfully'], 200);
    }

    public function fetchAgrochemicals()
    {
        try {
            // Fetch all agrochemicals
            $agrochemicals = Agrochemicals::all();

            return response()->json($agrochemicals, 200);
        } catch (\Exception $e) {
            // Return error response in case of failure
            return response()->json([
                'message' => 'Failed to fetch agrochemicals',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
