<?php

namespace App\Http\Controllers;

use App\Models\Fields;
use App\Models\Variety;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class FieldsController extends Controller
{
    public function index(Request $request)
    {
        $currentTeam = $request->user()->currentTeam;

        if (!$currentTeam) {
            return Inertia::render('Fields/Index', [
                'pageTitle' => 'Fields',
                'fields' => [],
                'fieldCount' => 0,
            ]);
        }

        // Fetch fields with associated variety and team for the current team
        $fields = Fields::with(['variety.type', 'team'])
            ->where('team_id', $currentTeam->id)
            ->get();

        return Inertia::render('Fields/Index', [
            'pageTitle' => 'Fields',
            'fields' => $fields,
            'fieldCount' => $fields->count(),
        ]);
    }

    public function store(Request $request)
    {
        $currentTeam = $request->user()->currentTeam;

        if (!$currentTeam) {
            return response()->json(['error' => 'No team associated with the user.'], 403);
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'size' => 'required|string|max:50',
            'variety_id' => 'required|exists:varieties,id',
            'status' => 'required|in:active,inactive',
            'planted_at' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the field
        $field = Fields::create([
            'name' => $request->name,
            'size' => $request->size,
            'variety_id' => $request->variety_id,
            'status' => $request->status,
            'planted_at' => $request->planted_at,
            'team_id' => $currentTeam->id,
        ]);

        return response()->json(['field' => $field], 201);
    }

    public function update(Request $request, Fields $field)
    {
        $currentTeam = $request->user()->currentTeam;

        if (!$currentTeam || $field->team_id !== $currentTeam->id) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'size' => 'required|string|max:50',
            'variety_id' => 'required|exists:varieties,id',
            'status' => 'required|in:active,inactive',
            'planted_at' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update the field
        $field->update([
            'name' => $request->name,
            'size' => $request->size,
            'variety_id' => $request->variety_id,
            'status' => $request->status,
            'planted_at' => $request->planted_at,
        ]);

        return response()->json(['field' => $field], 200);
    }

    public function destroy(Request $request, Fields $field)
    {
        $currentTeam = $request->user()->currentTeam;

        if (!$currentTeam || $field->team_id !== $currentTeam->id) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        // Delete the field
        $field->delete();

        return response()->json(['message' => 'Field deleted successfully.'], 200);
    }
}
