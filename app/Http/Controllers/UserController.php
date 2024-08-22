<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function createUser(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:8',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'cin' => 'required|string|max:255',
            'device_name' => 'required|string',
        ]);

        // Create the user
        $user = User::create([
            'phone' => $validatedData['phone'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'client',
            'device_name' => $validatedData['device_name'],
            // Add any other user fields if needed
        ]);

        // Create the client associated with the new user
        $client = Client::create([
            'userID' => $user->id,
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'cin' => $validatedData['cin'],
        ]);

        return response()->json([
            'user' => $user,
            'client' => $client,
        ], Response::HTTP_CREATED);
    }
}
