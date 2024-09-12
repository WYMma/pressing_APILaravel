<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MissionController extends Controller
{
    // Retrieve all missions
    public function index()
    {
        $missions = Mission::with(['Commande'])->get();
        return response()->json($missions);
    }

    // Retrieve a single mission by ID
    public function show($id)
    {
        $mission = Mission::find($id);

        if (!$mission) {
            return response()->json(['message' => 'Mission not found'], 404);
        }

        return response()->json($mission);
    }

    // Create a new mission
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string',
            'equipeID' => 'nullable|exists:Equipe,equipeID',
            'date_mission' => 'required|date',
            'commandeID' => 'required|exists:Commandes,commandeID',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $mission = Mission::create($request->all());
        return response()->json($mission, 201);
    }

    // Update an existing mission
    public function update($id)
    {
        $mission = Mission::find($id);

        if (!$mission) {
            return response()->json(['message' => 'Mission not found'], 404);
        }

        $mission->update(['status' => 'Terminée']);
        return response()->json($mission);
    }

    // Delete a mission
    public function destroy($id)
    {
        $mission = Mission::find($id);

        if (!$mission) {
            return response()->json(['message' => 'Mission not found'], 404);
        }

        $mission->delete();
        return response()->json(['message' => 'Mission deleted successfully']);
    }
}


