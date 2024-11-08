<?php

namespace App\Http\Controllers;

use App\Models\Agrochemicals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            'pageTitle' => 'Agrochemical Management',
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
            'mixing_order' => 'nullable|integer',
            'mixing_category' => 'nullable|in:Water,Water Quality Regulators,Water-Soluble Packets,Dry Formulations,Suspension Concentrates,Emulsifiable Concentrates,Adhesives,Water-Soluble Liquids,Foliar Feedings'
        ]);

        // Create the new crop entry
        $agrochemical = Agrochemicals::create($validatedData);

        return response()->json(['message' => 'Agrochemical created successfully', 'agrochemical' => $agrochemical], 201);
    }

    public function destroy($id)
    {
        try {
            // Find the user by ID
            $agrochemical = Agrochemicals::findOrFail($id);

            // Soft delete the user
            $agrochemical->delete();

            // Return a JSON response to the axios call
            return response()->json(['message' => 'User soft deleted successfully.'], 200);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error deleting user: " . $e->getMessage());

            // Return an error response
            return response()->json(['message' => 'Error deleting user.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Temporarily skip validation to test if the issue is with validation rules
        $agrochemical = Agrochemicals::find($id);

        if (!$agrochemical) {
            return response()->json(['error' => 'Agrochemical not found'], 404);
        }

        $agrochemical->update($request->all());

        return response()->json([
            'message' => 'Record updated successfully',
            'data' => $agrochemical
        ], 200);
    }

    public function fetchAgrochemicals()
    {
        $agrochemicals = Agrochemicals::select('id', 'name', 'mixing_order')->get();

        return response()->json($agrochemicals, 200);
    }
}
