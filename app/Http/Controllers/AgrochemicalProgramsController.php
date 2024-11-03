<?php

namespace App\Http\Controllers;

use App\Models\AgrochemicalPrograms;
use App\Http\Requests\StoreAgrochemicalProgramsRequest;
use App\Http\Requests\UpdateAgrochemicalProgramsRequest;
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAgrochemicalProgramsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AgrochemicalPrograms $agrochemicalPrograms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AgrochemicalPrograms $agrochemicalPrograms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAgrochemicalProgramsRequest $request, AgrochemicalPrograms $agrochemicalPrograms)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AgrochemicalPrograms $agrochemicalPrograms)
    {
        //
    }
}
