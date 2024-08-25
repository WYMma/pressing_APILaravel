<?php

namespace App\Http\Controllers;

use App\Models\Addresse;
use Illuminate\Http\Request;

class AddresseController extends Controller
{
    // Get all addresses for a specific client
    public function getAddresses($clientId)
    {
        $addresses = Addresse::where('clientID', $clientId)->get();
        return response()->json($addresses);
    }

    // Create a new address for a client
    public function createAddress(Request $request)
    {
        $validatedData = $request->validate([
            'clientID' => 'required|integer',
            'area' => 'required|string|max:50',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'type' => 'nullable|string|max:255',
        ]);

        $address = Addresse::create($validatedData);
        return response()->json(['address' => $address], 201);
    }

    // Update an existing address
    public function updateAddress(Request $request, $addressID)
    {
        $address = Addresse::findOrFail($addressID);

        $validatedData = $request->validate([
            'area' => 'required|string|max:50',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'type' => 'nullable|string|max:255',
        ]);

        $address->update($validatedData);
        return response()->json(['message' => 'Address updated successfully', 'address' => $address]);
    }

    // Delete an address
    public function deleteAddress($addressID)
    {
        $address = Addresse::findOrFail($addressID);
        $address->delete();

        return response()->json(['message' => 'Address deleted successfully']);
    }
}
