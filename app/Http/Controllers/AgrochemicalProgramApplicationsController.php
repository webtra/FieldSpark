<?php

namespace App\Http\Controllers;

use App\Models\AgrochemicalProgramApplications;
use App\Http\Requests\StoreAgrochemicalProgramApplicationsRequest;
use App\Http\Requests\UpdateAgrochemicalProgramApplicationsRequest;
use App\Mail\ApplicationSheetNotification;
use App\Models\AgrochemicalPrograms;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Spatie\LaravelPdf\Facades\Pdf;

class AgrochemicalProgramApplicationsController extends Controller
{
    public function index()
    {
        $agrochemicalProgramApplications = AgrochemicalProgramApplications::with('agrochemicalProgram')->get();
        $agrochemicalProgramApplicationCount = $agrochemicalProgramApplications->count();

        // dd($agrochemicalProgramApplications);

        return Inertia::render('AgrochemicalProgramApplication/Index', [
            'agrochemicalProgramApplications' => $agrochemicalProgramApplications,
            'agrochemicalProgramApplicationCount' => $agrochemicalProgramApplicationCount,
            'pageTitle' => 'Agrochemical Program Application Management',
        ]);
    }

    // public function generateApplicationSheet(Request $request)
    // {
    //     try {
    //         $applications = $request->input('programs');
    //         Log::info('Received request to generate or update application sheet', ['input' => $applications]);

    //         // Extract program_ids from the incoming request data
    //         $incomingProgramIds = array_map(function ($application) {
    //             return $application['program_id'];
    //         }, $applications);

    //         // Log the incoming program IDs for debugging
    //         Log::info('Incoming agrochemical program IDs', ['ids' => $incomingProgramIds]);

    //         // Find existing records in the database related to the incoming agrochemical_program_ids
    //         $existingApplications = AgrochemicalProgramApplications::whereIn('program_id', $incomingProgramIds)->get();

    //         // Log existing applications for debugging
    //         Log::info('Existing applications found in the database', ['records' => $existingApplications]);

    //         // Update or create records as needed
    //         foreach ($applications as $index => $applicationData) {
    //             Log::info('Processing application data', ['record_index' => $index, 'data' => $applicationData]);

    //             $existingApplication = $existingApplications->firstWhere('program_id', $applicationData['program_id']);

    //             if ($existingApplication) {
    //                 // Update existing application
    //                 Log::info('Updating existing application record', ['record_index' => $index, 'existing_application_id' => $existingApplication->id]);
    //                 $existingApplication->update($applicationData);
    //             } else {
    //                 // Create a new record
    //                 Log::info('Creating new application record', ['record_index' => $index]);
    //                 AgrochemicalProgramApplications::create($applicationData);
    //             }
    //         }

    //         // Find records that need to be deleted (existing in DB but not in the incoming request)
    //         $recordsToDelete = AgrochemicalProgramApplications::whereNotIn('program_id', $incomingProgramIds)
    //             ->whereIn('program_id', $existingApplications->pluck('program_id'))
    //             ->get();

    //         // Delete the records and log the deletion
    //         foreach ($recordsToDelete as $record) {
    //             Log::info('Deleting removed application record', ['record_id' => $record->id]);
    //             $record->delete();
    //         }

    //         return response()->json(['message' => 'Application records processed successfully.'], 200);
    //     } catch (\Exception $e) {
    //         Log::error('Error while processing application records', ['exception_message' => $e->getMessage(), 'exception_trace' => $e->getTraceAsString()]);
    //         return response()->json(['message' => 'An error occurred while processing application records.'], 500);
    //     }
    // }

    public function generateApplicationSheet(Request $request)
    {
        try {
            // Log the start of the method
            Log::info('Starting generateApplicationSheet method', ['request_data' => $request->all()]);

            // Extract incoming application data
            $applications = $request->input('programs');
            Log::info('Received request to generate or update application sheet', ['applications_count' => count($applications)]);

            // Extract program IDs from the input data
            $incomingProgramIds = array_map(fn($application) => $application['program_id'], $applications);
            Log::info('Extracted incoming program IDs', ['program_ids' => $incomingProgramIds]);

            // Fetch existing applications from the database for the incoming program IDs
            $existingApplications = AgrochemicalProgramApplications::whereIn('program_id', $incomingProgramIds)->get();
            Log::info('Fetched existing applications from the database', ['existing_count' => $existingApplications->count()]);

            // Update or create application records as needed
            foreach ($applications as $index => $applicationData) {
                Log::info('Processing application data', ['record_index' => $index, 'data' => $applicationData]);

                $existingApplication = $existingApplications->firstWhere('program_id', $applicationData['program_id']);

                if ($existingApplication) {
                    Log::info('Updating existing application record', ['application_id' => $existingApplication->id]);
                    $existingApplication->update($applicationData);
                } else {
                    Log::info('Creating new application record', ['record_index' => $index]);
                    AgrochemicalProgramApplications::create($applicationData);
                }
            }

            // Identify records that need to be deleted (not in the incoming data)
            $recordsToDelete = $existingApplications->filter(fn($record) => !in_array($record->program_id, $incomingProgramIds));
            Log::info('Identified records for deletion', ['records_to_delete_count' => $recordsToDelete->count()]);

            foreach ($recordsToDelete as $record) {
                Log::info('Deleting record', ['record_id' => $record->id]);
                $record->delete();
            }

            // Fetch programs with their relationships for the PDF generation
            $programs = AgrochemicalPrograms::with(['agrochemicalProgramApplications.agrochemical', 'crop'])
                ->whereIn('id', $incomingProgramIds)
                ->get();

            Log::info('Fetched programs with related applications for PDF generation', ['programs_count' => $programs->count()]);

            // Generate the PDF using Spatie's Laravel PDF package
            $pdf = Pdf::view('pdf.application_sheet', ['programs' => $programs])
                ->format('a4')
                //->landscape()
                ->name('application_sheet.pdf');

            Log::info('PDF generated successfully. Preparing to send response');

            $users = User::where('role_id', 3)->get();
            $link = route('application.sheet.fill'); // Replace with your route name or URL

            foreach ($users as $user) {
                Mail::to($user->email)->send(new ApplicationSheetNotification($link, $user->first_name, $user->last_name));
            }

            Log::info('Emails sent to all users with role_id 3');

            return $pdf->download();
        } catch (\Exception $e) {
            // Log any exceptions that occur
            Log::error('Error while processing application records', [
                'exception_message' => $e->getMessage(),
                'exception_trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'An error occurred while processing application records.'], 500);
        }
    }
}
