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
}
