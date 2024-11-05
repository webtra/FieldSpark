<?php

namespace App\Http\Controllers;

use App\Models\AgrochemicalPrograms;
use App\Http\Requests\StoreAgrochemicalProgramsRequest;
use App\Http\Requests\UpdateAgrochemicalProgramsRequest;
use Illuminate\Http\Request;
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

        return Inertia::render('AgrochemicalProgram/Index', [
            'agrochemicalPrograms' => $agrochemicalPrograms,
            'agrochemicalProgramCount' => $agrochemicalProgramCount,
            'pageTitle' => 'Agrochemical Programs',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'rows' => 'required|array',
            'rows.*.crop_id' => 'required|integer|exists:crops,id',
            'rows.*.agrochemical_id' => 'required|integer|exists:agrochemicals,id',
            'rows.*.planned_application_date' => 'required|date',
        ]);

        // Loop through each row and create a new record in the database
        foreach ($data['rows'] as $row) {
            AgrochemicalPrograms::create([
                'crop_id' => $row['crop_id'],
                'agrochemical_id' => $row['agrochemical_id'],
                'planned_application_date' => $row['planned_application_date'],
            ]);
        }

        return response()->json(['message' => 'Agrochemical program applications saved successfully.']);
    }
}
