<?php

namespace App\Http\Controllers;

use App\Models\AgrochemicalPrograms;
use App\Models\Agrochemicals;
use App\Models\Crops;
use App\Models\Cultivars;
use App\Models\SupportTickets;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'pageTitle' => 'Dashboard',
            'user' => Auth::user(),
        ]);
    }

    public function stats()
    {
        $userId = Auth::id();

        // Calculate the start and end dates of the current week (Sunday to Saturday)
        $currentWeekStart = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $currentWeekEnd = Carbon::now()->endOfWeek(Carbon::SATURDAY);

        // Calculate the start and end dates of the previous week (Sunday to Saturday)
        $previousWeekStart = $currentWeekStart->copy()->subWeek();
        $previousWeekEnd = $currentWeekEnd->copy()->subWeek();

        // Current week counts
        $totalCultivars = Cultivars::whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])->count();
        $totalCrops = Crops::whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])->count();
        $totalAgrochemicals = Agrochemicals::whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])->count();
        $totalPrograms = AgrochemicalPrograms::whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])->count();
        $openTickets = SupportTickets::where('user_id', $userId)
            ->where('status', 'Open')
            ->whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])
            ->count();
        $closedTickets = SupportTickets::where('user_id', $userId)
            ->where('status', 'Closed')
            ->whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])
            ->count();

        // Previous week counts
        $previousWeekCultivars = Cultivars::whereBetween('created_at', [$previousWeekStart, $previousWeekEnd])->count();
        $previousWeekCrops = Crops::whereBetween('created_at', [$previousWeekStart, $previousWeekEnd])->count();
        $previousWeekAgrochemicals = Agrochemicals::whereBetween('created_at', [$previousWeekStart, $previousWeekEnd])->count();
        $previousWeekPrograms = AgrochemicalPrograms::whereBetween('created_at', [$previousWeekStart, $previousWeekEnd])->count();
        $previousWeekOpenTickets = SupportTickets::where('user_id', $userId)
            ->where('status', 'Open')
            ->whereBetween('created_at', [$previousWeekStart, $previousWeekEnd])
            ->count();
        $previousWeekClosedTickets = SupportTickets::where('user_id', $userId)
            ->where('status', 'Closed')
            ->whereBetween('created_at', [$previousWeekStart, $previousWeekEnd])
            ->count();

        // Helper function to calculate percentage change
        function calculateChange($current, $previous)
        {
            return $previous ? (($current - $previous) / $previous) * 100 : ($current ? 100 : 0);
        }

        return response()->json([
            'totalCultivars' => $totalCultivars,
            'totalCrops' => $totalCrops,
            'totalAgrochemicals' => $totalAgrochemicals,
            'totalPrograms' => $totalPrograms,
            'openTickets' => $openTickets,
            'closedTickets' => $closedTickets,
            'changeCultivars' => calculateChange($totalCultivars, $previousWeekCultivars),
            'changeCrops' => calculateChange($totalCrops, $previousWeekCrops),
            'changeAgrochemicals' => calculateChange($totalAgrochemicals, $previousWeekAgrochemicals),
            'changePrograms' => calculateChange($totalPrograms, $previousWeekPrograms),
            'changeOpenTickets' => calculateChange($openTickets, $previousWeekOpenTickets),
            'changeClosedTickets' => calculateChange($closedTickets, $previousWeekClosedTickets),
        ]);
    }

    public function activities()
    {
        // For example, returning recent activity mock data
        return response()->json([
            ['id' => 1, 'type' => 'Program', 'description' => 'Created Agrochemical Program for Crop A'],
            ['id' => 2, 'type' => 'Support Ticket', 'description' => 'Opened ticket for Crop B issue'],
            ['id' => 3, 'type' => 'Cultivar', 'description' => 'Added new cultivar "Alpha" to database'],
        ]);
    }
}
