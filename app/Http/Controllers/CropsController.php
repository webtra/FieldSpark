<?php

namespace App\Http\Controllers;

use App\Models\Crops;
use App\Http\Requests\StoreCropsRequest;
use App\Http\Requests\UpdateCropsRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CropsController extends Controller
{
    /**
     * Display a listing of crops.
     */
    public function index()
    {
        // Eager load `cultivar` relationship to access cultivar names
        $crops = Crops::with('cultivar')->get();
        $cropCount = Crops::count();

        return Inertia::render('Crops/Index', [
            'crops' => $crops,
            'cropCount' => $cropCount,
            'pageTitle' => 'Crops',
        ]);
    }

    public function update(Request $request, Crops $crop)
    {
        // Validate incoming data with custom error message
        $validatedData = $request->validate([
            'cultivar_id' => 'nullable|exists:cultivars,id',
            'block_number' => 'nullable',
            'planting_date' => 'nullable',
            'harvest_date' => 'nullable',
            'location' => 'nullable|required',
            'status' => 'nullable',
            'size' => 'nullable',
        ], [
            'cultivar_id.exists' => 'The selected cultivar does not exist.',
            'status.in' => 'The status must be one of the following: planted, growing, harvested, or failed.',
        ]);

        // Manually assign validated data to crop
        $crop->fill($validatedData);

        // Save the crop and return response
        if ($crop->save()) {
            return response()->json(['message' => 'Crop updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to update crop'], 500);
        }
    }

    /**
     * Remove the specified crop from the database.
     */
    public function destroy(Crops $crop)
    {
        $crop->delete();

        return response()->json(['message' => 'Crop deleted successfully'], 200);
    }

    /**
     * Create a new crop in the database.
     */
    public function store(Request $request)
    {
        // Validate incoming data with custom error message
        $validatedData = $request->validate([
            'cultivar_id' => 'required|exists:cultivars,id',
            'block_number' => 'nullable|string',
            'planting_date' => 'nullable|date',
            'harvest_date' => 'nullable|date',
            'location' => 'required|string',
            'status' => 'nullable|string|in:planted,growing,harvested,failed',
            'size' => 'nullable|numeric',
        ], [
            'cultivar_id.required' => 'The cultivar field is required.',
            'cultivar_id.exists' => 'The selected cultivar does not exist.',
            'status.in' => 'The status must be one of the following: planted, growing, harvested, or failed.',
        ]);

        // Create the new crop entry
        $crop = Crops::create($validatedData);

        return response()->json(['message' => 'Crop created successfully', 'crop' => $crop], 201);
    }
}
