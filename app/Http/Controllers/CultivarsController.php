<?php

namespace App\Http\Controllers;

use App\Models\Cultivars;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Spatie\LaravelPdf\Facades\Pdf;

class CultivarsController extends Controller
{
    public function download()
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
     * Display a listing of cultivars for API requests (JSON response).
     */
    public function fetchCultivars()
    {
        $cultivars = Cultivars::select('id', 'prime_name')->get();

        return response()->json($cultivars, 200);
    }
}
