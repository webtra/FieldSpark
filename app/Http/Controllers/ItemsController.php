<?php

namespace App\Http\Controllers;

use App\Models\Inventories;
use App\Models\Items;
use App\Models\Prices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ItemsController extends Controller
{
    public function index(Request $request)
    {
        $currentTeam = $request->user()->currentTeam;

        if (!$currentTeam) {
            return Inertia::render('Items/Index', [
                'pageTitle' => 'Items',
                'items' => [],
                'itemCount' => 0,
            ]);
        }

        // Fetch storerooms with associated variety and team for the current team
        $items = Items::with(['team'])
            ->where('team_id', $currentTeam->id)
            ->get();

        return Inertia::render('Items/Index', [
            'pageTitle' => 'Items',
            'items' => $items,
            'itemCount' => $items->count(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Items/Create', [
            'pageTitle' => 'Add Item',
        ]);
    }

    public function store(Request $request)
    {
        // Get the current team of the authenticated user
        $currentTeam = $request->user()->currentTeam;

        if (!$currentTeam) {
            return response()->json([
                'success' => false,
                'message' => 'No current team found for the user.',
            ], 400);
        }

        $teamId = $currentTeam->id;

        // Validate the request (team_id is no longer validated here)
        $request->validate([
            'storeroom_id' => 'required|exists:storerooms,id',
            'name' => 'required|string|max:255',
            'unit' => 'required|string|in:g,kg,ml,l',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'recommended_dosage' => 'nullable|numeric|min:0',
            'category' => 'required|string|in:Herbicide,Pesticide,Fungicide,Fertilizer,Growth Regulator',
            'application_method' => 'required|string|in:Spray,Granular,Drip,Foliar',
            'toxicity_level' => 'required|string|in:Low,Medium,High',
            'restricted_use' => 'required|boolean',
            'recommended_application_frequency' => 'nullable|string',
            'reentry_interval' => 'nullable|integer|min:0',
            'pre_harvest_interval' => 'nullable|integer|min:0',
            'safety_precautions' => 'nullable|string',
            'mixing_category' => 'required|string|in:Water,Water Quality Regulators,Water-Soluble Packets,Dry Formulations,Suspension Concentrates,Emulsifiable Concentrates,Adhesives,Water-Soluble Liquids,Foliar Feedings',
            'mixing_compatibility' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        DB::beginTransaction();

        try {
            // Save the item to the items table
            $item = Items::create([
                'team_id' => $teamId, // Use current team ID
                'storeroom_id' => $request->storeroom_id,
                'name' => $request->name,
                'unit' => $request->unit,
                'size' => $request->size,
                'description' => $request->description,
                'recommended_dosage' => $request->recommended_dosage,
                'category' => $request->category,
                'application_method' => $request->application_method,
                'toxicity_level' => $request->toxicity_level,
                'restricted_use' => $request->restricted_use,
                'recommended_application_frequency' => $request->recommended_application_frequency,
                'reentry_interval' => $request->reentry_interval,
                'pre_harvest_interval' => $request->pre_harvest_interval,
                'safety_precautions' => $request->safety_precautions,
                'mixing_category' => $request->mixing_category,
                'mixing_compatibility' => $request->mixing_compatibility,
            ]);

            Log::info('Item created: ' . $item);

            // Save the quantity to the inventories table
            $inventory = Inventories::create([
                'team_id' => $teamId, // Use current team ID
                'storeroom_id' => $request->storeroom_id,
                'item_id' => $item->id,
                'quantity' => $request->quantity,
            ]);

            Log::info('Inventory created: ' . $inventory);

            // Save the price and date to the prices table
            $price = Prices::create([
                'team_id' => $teamId, // Use current team ID
                'item_id' => $item->id,
                'inventory_id' => $inventory->id,
                'price' => $request->price,
                'date' => $request->date,
            ]);

            Log::info('Price created: ' . $price);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Item, inventory, and price saved successfully.',
                'item' => $item,
                'inventory' => $inventory,
                'price' => $price,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
