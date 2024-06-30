<?php

namespace App\Http\Controllers;

use App\Models\Services;
use App\Http\Requests\StoreServicesRequest;
use App\Http\Requests\UpdateServicesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ServicesController extends Controller
{
    public function createNewService(Request $request)
    {
        // Log::info('Starting to process the service creation request.');

        // Validate the incoming request data
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'price' => 'required|numeric',
                'status' => 'required|string|in:Active,Pending,Inactive'
            ]);
        } catch (\Exception $e) {
            // Log::error('Validation failed.', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Validation failed', 'error' => $e->getMessage()], 400);
        }

        // Create a new service using the validated data
        $service = new Services(); // Ensure this is the correct model name
        $service->name = $validated['name'];
        $service->description = $validated['description'];
        $service->price = $validated['price'];
        $service->status = $validated['status'];

        // Attempt to save the service to the database
        try {
            $service->save();
            // Log::info('Service created successfully.', ['id' => $service->id]);
            return response()->json(['message' => 'Service created successfully', 'service' => $service], 201);
        } catch (\Exception $e) {
            // Log::error('Failed to save the service.', ['error' => $e->getMessage(), 'service' => $service]);
            return response()->json(['message' => 'Failed to create service', 'error' => $e->getMessage()], 500);
        }
    }

    public function getAllServices()
    {
        $services = Services::all(); // Make sure to use pagination if necessary
        return response()->json(['services' => $services]);
    }

    public function project_estimation()
    {
        return Inertia::render('Project/Estimation', [
            'page_name' => 'Project Estimation',
        ]);
    }
}
