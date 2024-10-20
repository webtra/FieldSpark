<?php

namespace App\Http\Controllers;

use App\Models\Cultivars;
use App\Http\Requests\StoreCultivarsRequest;
use App\Http\Requests\UpdateCultivarsRequest;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Spatie\LaravelPdf\Facades\Pdf;

class CultivarsController extends Controller
{
    public function downloadPDF()
    {
        try {
            // Fetch your data (e.g., cultivars)
            $cultivars = Cultivars::all();

            // Generate the PDF using the view and pass the data
            $pdf = Pdf::view('pdf.cultivars', ['cultivars' => $cultivars])
                ->format('a4')   // Specify paper format if necessary
                ->orientation('portrait');  // You can also specify landscape

            // Return the PDF as a download
            return $pdf->download('cultivars.pdf');
        } catch (\Exception $e) {
            // Handle and log the error if something goes wrong
            Log::error('Error generating PDF: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to generate PDF'], 500);
        }
    }

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
