<?php

namespace App\Http\Controllers;

use App\Models\Varieties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class VarietiesController extends Controller
{
    /**
     * Display a listing of the types.
     */
    public function index(Request $request)
    {
        $currentTeam = $request->user()->currentTeam;

        if (!$currentTeam) {
            return Inertia::render('Varieties/Index', [
                'pageTitle' => 'Varieties',
                'varieties' => [],
                'varietyCount' => 0,
            ]);
        }

        // Fetch varieties for the current team with related team and type
        $varieties = Varieties::with(['team', 'type'])
            ->where('team_id', $currentTeam->id)
            ->get();

        return Inertia::render('Varieties/Index', [
            'pageTitle' => 'Varieties',
            'varieties' => $varieties,
            'varietyCount' => $varieties->count(),
        ]);
    }

    /**
     * Store a newly created type in the database.
     */
    public function store(Request $request)
    {
        // Get the current team of the authenticated user
        $currentTeam = $request->user()->currentTeam;

        if (!$currentTeam) {
            return response()->json([
                'message' => 'No current team found for the user.',
            ], 400);
        }

        // Validate the incoming request, including the type_id
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type_id' => 'required|exists:types,id',
            'yield_potential' => 'nullable|string',
            'water_requirements' => 'nullable|integer',
            'soil_type' => 'nullable|string',
            'plant_spacing' => 'nullable|integer',
            'row_spacing' => 'nullable|integer',
            'root_depth' => 'nullable|string',
            'growth_season' => 'nullable|string|in:spring,summer,autumn,winter',
        ]);

        // Add the team_id to the validated data
        $validatedData['team_id'] = $currentTeam->id;

        // Create the new variety
        $variety = Varieties::create($validatedData);

        return response()->json([
            'message' => 'Variety created successfully.',
            'variety' => $variety,
        ], 201);
    }


    /**
     * Update the specified type in the database.
     */
    public function update(Request $request, Varieties $variety)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'type_id' => 'required|exists:types,id',
            'name' => 'required|string|max:255',
            'yield_potential' => 'nullable|string',
            'water_requirements' => 'nullable|integer',
            'soil_type' => 'nullable|string',
            'plant_spacing' => 'nullable|integer',
            'row_spacing' => 'nullable|integer',
            'root_depth' => 'nullable|string',
            'growth_season' => 'nullable|string|in:spring,summer,autumn,winter',
        ]);

        // Update the type
        $variety->fill($validatedData);

        // Save the crop and return response
        if ($variety->save()) {
            return response()->json(['message' => 'Variety updated successfully!'], 200);
        } else {
            return response()->json(['message' => 'Failed to update variety!'], 500);
        }
    }

    /**
     * Remove the specified type from the database.
     */
    public function destroy(Varieties $variety)
    {
        try {
            $variety->delete();

            return response()->json(['message' => 'Variety deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting variety.', 'error' => $e->getMessage()], 500);
        }
    }
}
