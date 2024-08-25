<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    public function getClientByUserId($userId)
    {
        $client = Client::where('userID', $userId)->first();

        if (!$client) {
            return response()->json(['error' => 'Client not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($client);
    }

    public function updateClient(Request $request, $clientId) {
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'cin' => 'required|string',
            'email' => 'string',
        ]);

        $client = Client::findOrFail($clientId);

        $client->update($validatedData);

        return response()->json($client);
    }
}
