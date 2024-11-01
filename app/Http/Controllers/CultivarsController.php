<?php

namespace App\Http\Controllers;

use App\Models\Cultivars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Spatie\LaravelPdf\Facades\Pdf;

class CultivarsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cultivars = Cultivars::all();
        $cultivarCount = Cultivars::count();

        return Inertia::render('Cultivars/Index', [
            'cultivars' => $cultivars,
            'cultivarCount' => $cultivarCount,
            'pageTitle' => 'Cultivars',
        ]);
    }

    /**
     * Display a listing of cultivars for API requests (JSON response).
     */
    public function fetchCultivars()
    {
        $cultivars = Cultivars::select('id', 'prime_name')->get();

        return response()->json($cultivars, 200);
    }

    public function store(Request $request)
    {
        // Validation rules
        $validatedData = $request->validate([
            'code' => 'nullable|string|unique:cultivars,code',
            'name' => 'required|string|max:100',
            'growth_season' => 'required|in:spring,summer,autumn,winter',
            'maturity_days' => 'nullable|integer',
            'yield_potential' => 'nullable|numeric|min:0',
            'water_requirements' => 'nullable|integer',
            'soil_type' => 'nullable|string|max:100',
            'plant_spacing' => 'nullable|numeric|min:0',
            'root_depth' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);

        // Generate a unique code based on the name
        $generateCode = $this->generateUniqueCode($validatedData['name']);

        // Create the cultivar with validated data
        $cultivar = Cultivars::create([
            'code' => $generateCode,
            'name' => $validatedData['name'],
            'growth_season' => $validatedData['growth_season'],
            'maturity_days' => $validatedData['maturity_days'] ?? null,
            'yield_potential' => $validatedData['yield_potential'] ?? null,
            'water_requirements' => $validatedData['water_requirements'] ?? null,
            'soil_type' => $validatedData['soil_type'] ?? null,
            'plant_spacing' => $validatedData['plant_spacing'] ?? null,
            'root_depth' => $validatedData['root_depth'] ?? null,
            'notes' => $validatedData['notes'] ?? 'N/A', // Default to 'N/A' if notes are not provided
        ]);

        return response()->json(['message' => 'Cultivar created successfully', 'data' => $cultivar], 201);
    }

    /**
     * Generate a unique code based on the name of the cultivar.
     *
     * @param string $name
     * @return string
     */
    private function generateUniqueCode($name)
    {
        // Slugify the name to create a base code
        $baseCode = \Illuminate\Support\Str::slug($name);

        // Find the highest existing suffix for cultivars with the same base code
        $latestCultivarWithCode = Cultivars::where('code', 'like', "$baseCode-%")
            ->orderByDesc('code')
            ->value('code');

        // Determine the next suffix number (e.g., if latest is baseCode-0002, next is baseCode-0003)
        $nextSuffix = $latestCultivarWithCode
            ? (int)substr($latestCultivarWithCode, strrpos($latestCultivarWithCode, '-') + 1) + 1
            : 1;

        // Format the code as baseCode-0001, baseCode-0002, etc.
        return sprintf('%s-%04d', $baseCode, $nextSuffix);
    }

    // Update an existing cultivar
    public function update(Request $request, $id)
    {
        $cultivar = Cultivars::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'growth_season' => 'required|in:spring,summer,autumn,winter',
            'maturity_days' => 'nullable|integer',
            'yield_potential' => 'nullable|numeric|min:0',
            'water_requirements' => 'nullable|integer',
            'soil_type' => 'nullable|string|max:100',
            'plant_spacing' => 'nullable|numeric|min:0',
            'root_depth' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);

        $cultivar->update($validatedData);

        return response()->json(['message' => 'Cultivar updated successfully', 'data' => $cultivar], 200);
    }

    // Delete a specific cultivar
    public function destroy($id)
    {
        $cultivar = Cultivars::findOrFail($id);
        $cultivar->delete();

        return response()->json(['message' => 'Cultivar deleted successfully'], 200);
    }
}
