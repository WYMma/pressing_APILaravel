<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ApiKeyController extends Controller
{
    // Retrieve all API keys
    public function index()
    {
        // Retrieve all API keys, decrypting them before sending them to the view or client
        $apiKeys = ApiKey::all();
        return response()->json($apiKeys);
    }

    // Store a new API key
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'api_key' => 'required|string',
        ]);

        $apiKey = new ApiKey();
        $apiKey->name = $request->input('name');
        $apiKey->api_key = $request->input('api_key'); // Encryption happens automatically in the model
        $apiKey->save();

        return response()->json(['message' => 'API key created successfully', 'data' => $apiKey], 201);
    }

    // Retrieve a specific API key by ID
    public function show($id)
    {
        $apiKey = ApiKey::findOrFail($id);
        return response()->json($apiKey);
    }

    // Update an existing API key
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'api_key' => 'required|string',
        ]);

        $apiKey = ApiKey::findOrFail($id);
        $apiKey->name = $request->input('name');
        $apiKey->api_key = $request->input('api_key'); // Encryption happens automatically in the model
        $apiKey->save();

        return response()->json(['message' => 'API key updated successfully', 'data' => $apiKey]);
    }

    // Delete an API key
    public function destroy($id)
    {
        $apiKey = ApiKey::findOrFail($id);
        $apiKey->delete();

        return response()->json(['message' => 'API key deleted successfully']);
    }
}
