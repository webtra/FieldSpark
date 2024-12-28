<?php

namespace App\Http\Controllers;

use App\Models\Storerooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class StoreroomsController extends Controller
{
    public function index(Request $request)
    {
        $currentTeam = $request->user()->currentTeam;

        if (!$currentTeam) {
            return Inertia::render('Storerooms/Index', [
                'pageTitle' => 'Storerooms',
                'storerooms' => [],
                'storeroomCount' => 0,
            ]);
        }

        // Fetch storerooms with associated variety and team for the current team
        $storerooms = Storerooms::with(['team'])
            ->where('team_id', $currentTeam->id)
            ->get();

        return Inertia::render('Storerooms/Index', [
            'pageTitle' => 'Storerooms',
            'storerooms' => $storerooms,
            'storeroomCount' => $storerooms->count(),
        ]);
    }

    public function update(Request $request, Storerooms $storeroom)
    {
        $currentTeam = $request->user()->currentTeam;

        // Check team authorization
        if (!$currentTeam || $storeroom->team_id !== $currentTeam->id) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'address_line_1' => 'nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'address_line_3' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'status' => 'nullable|in:active,inactive,suspended',
            'is_default' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update the storeroom
        $storeroom->update([
            'name' => $request->name,
            'country' => $request->country,
            'address_line_1' => null,
            'address_line_2' => null,
            'address_line_3' => null,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'status' => 'active',
            'is_default' => null,
        ]);

        return response()->json(['storeroom' => $storeroom], 200);
    }
}
