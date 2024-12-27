<?php

namespace App\Http\Controllers;

use App\Models\Types;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class TypesController extends Controller
{
    /**
     * Display a listing of the types.
     */
    public function index(Request $request)
    {
        $currentTeam = $request->user()->currentTeam;

        $types = $currentTeam->types;

//        Log::info('Types for team ' . $currentTeam->id . ': ' . $types);

        return Inertia::render('Types/Index', [
            'pageTitle' => 'Types',
            'types' => $types,
            'typeCount' => $types->count(),
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

        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Add the team_id to the validated data
        $validatedData['team_id'] = $currentTeam->id;

        // Create the new type
        $type = Types::create($validatedData);

        return response()->json([
            'message' => 'Type created successfully.',
            'type' => $type,
        ], 201);
    }

    /**
     * Update the specified type in the database.
     */
    public function update(Request $request, Types $type)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Update the type
        $type->fill($validatedData);

        // Save the crop and return response
        if ($type->save()) {
            return response()->json(['message' => 'Type updated successfully!'], 200);
        } else {
            return response()->json(['message' => 'Failed to update type!'], 500);
        }
    }

    /**
     * Remove the specified type from the database.
     */
    public function destroy(Types $type)
    {
        try {
            $type->delete();

            return response()->json(['message' => 'Type deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting type.', 'error' => $e->getMessage()], 500);
        }
    }


    /**
     * Fetch types for the current user's team.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(Request $request)
    {
        // Get the current team of the authenticated user
        $currentTeam = $request->user()->currentTeam;

        if (!$currentTeam) {
            return response()->json([
                'message' => 'No current team found for the user.',
            ], 400);
        }

        // Fetch types belonging to the current team
        $types = Types::where('team_id', $currentTeam->id)->get(['id', 'name']);

        return response()->json([
            'message' => 'Types fetched successfully.',
            'types' => $types,
        ]);
    }
}
