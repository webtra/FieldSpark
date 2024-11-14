<?php

namespace App\Http\Controllers;

use App\Models\AgrochemicalPrograms;
use App\Http\Requests\StoreAgrochemicalProgramsRequest;
use App\Http\Requests\UpdateAgrochemicalProgramsRequest;
use App\Models\Crops;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class AgrochemicalProgramsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agrochemicalPrograms = AgrochemicalPrograms::all();
        $agrochemicalProgramCount = AgrochemicalPrograms::count();

        // Retrieve all agrochemical programs with their related agrochemical and crop details
        $agrochemicalPrograms = AgrochemicalPrograms::with(['agrochemical', 'crop'])->get();

        return Inertia::render('AgrochemicalProgram/Index', [
            'agrochemicalPrograms' => $agrochemicalPrograms,
            'agrochemicalProgramCount' => $agrochemicalProgramCount,
            'pageTitle' => 'Agrochemical Program Management',
        ]);
    }

    public function store(Request $request)
    {
        Log::info('Starting the store process for agrochemical programs.');

        $data = $request->validate([
            'rows' => 'required|array',
            'rows.*.crop_id' => 'required|integer|exists:crops,id',
            'rows.*.agrochemical_id' => 'required|integer|exists:agrochemicals,id',
            'rows.*.planned_application_date' => 'required|date',
        ]);

        try {
            foreach ($data['rows'] as $row) {
                Log::info('Processing row:', $row);

                $blockNumber = Crops::findOrFail($row['crop_id'])->block_number;
                $programName = $blockNumber . '-Program';

                AgrochemicalPrograms::create([
                    'crop_id' => $row['crop_id'],
                    'agrochemical_id' => $row['agrochemical_id'],
                    'name' => $programName,
                    'planned_application_date' => $row['planned_application_date'],
                ]);

                Log::info('Row successfully stored:', $row);
            }

            Log::info('All rows have been processed and stored successfully.');
            return response()->json(['message' => 'Agrochemical program applications saved successfully.']);
        } catch (\Exception $e) {
            Log::error('Error occurred while storing agrochemical program:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error saving agrochemical program.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        Log::info('Incoming request data for update:', $request->all());

        $data = $request->validate([
            'id' => 'required|integer|exists:agrochemical_programs,id',
            'crop_id' => 'required|integer|exists:crops,id',
            'agrochemical_id' => 'required|integer|exists:agrochemicals,id',
            'planned_application_date' => 'required|date',
        ]);

        try {
            Log::info('Processing update for row ID:', ['id' => $id]);

            $program = AgrochemicalPrograms::findOrFail($id);
            $program->update([
                'crop_id' => $data['crop_id'],
                'agrochemical_id' => $data['agrochemical_id'],
                'planned_application_date' => $data['planned_application_date'],
            ]);

            Log::info('Row successfully updated:', $data);

            return response()->json(['message' => 'Agrochemical program application updated successfully.']);
        } catch (\Exception $e) {
            Log::error('Error occurred while updating agrochemical program:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error updating agrochemical program.'], 500);
        }
    }

    public function delete($id)
    {
        try {
            Log::info('Attempting to delete agrochemical program with ID:', ['id' => $id]);

            $agrochemicalProgram = AgrochemicalPrograms::findOrFail($id);

            // Perform the deletion
            $agrochemicalProgram->delete();

            Log::info('Agrochemical program deleted successfully.', ['id' => $id]);

            return response()->json(['message' => 'Agrochemical Program deleted successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Error occurred while deleting agrochemical program:', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Error deleting agrochemical program.'], 500);
        }
    }
}
