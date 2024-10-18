<?php

namespace App\Http\Controllers;

use App\Models\Cultivars;
use App\Http\Requests\StoreCultivarsRequest;
use App\Http\Requests\UpdateCultivarsRequest;
use Inertia\Inertia;

class CultivarsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cultivars = Cultivars::all();
        
        return Inertia::render('Cultivars/Index', [
            'cultivars' => $cultivars,
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
    public function store(StoreCultivarsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cultivars $cultivars)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cultivars $cultivars)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCultivarsRequest $request, Cultivars $cultivars)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cultivars $cultivars)
    {
        //
    }
}
