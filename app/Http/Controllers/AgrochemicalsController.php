<?php

namespace App\Http\Controllers;

use App\Models\Agrochemicals;
use App\Http\Requests\StoreAgrochemicalsRequest;
use App\Http\Requests\UpdateAgrochemicalsRequest;
use Inertia\Inertia;

class AgrochemicalsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Agrochemical/Index');
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
    public function store(StoreAgrochemicalsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Agrochemicals $agrochemicals)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agrochemicals $agrochemicals)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAgrochemicalsRequest $request, Agrochemicals $agrochemicals)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agrochemicals $agrochemicals)
    {
        //
    }
}
