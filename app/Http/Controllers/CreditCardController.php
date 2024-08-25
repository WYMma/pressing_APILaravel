<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreditCard;

class CreditCardController extends Controller
{
    // Create a new credit card
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'number' => 'required|string',
            'holder' => 'required|string',
            'expiry' => 'required|string',
            'cvv' => 'required|string|max:4',
            'clientID' => 'required|integer',
        ]);

        $creditCard = CreditCard::create($validatedData);

        return response()->json($creditCard, 201);
    }

    // Update an existing credit card
    public function update(Request $request, $cardID)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'number' => 'required|string',
            'holder' => 'required|string',
            'expiry' => 'required|date_format:m/y',
            'cvv' => 'required|string',
        ]);

        // Find the credit card by ID
        $creditCard = CreditCard::findOrFail($cardID);

        // Update the credit card details
        $creditCard->update($validatedData);

        // Return a response
        return response()->json(['message' => 'Credit card updated successfully']);
    }

    // Retrieve credit cards by client ID
    public function index($clientID)
    {
        $creditCards = CreditCard::where('clientID', $clientID)->get();

        return response()->json($creditCards);
    }

    // Delete a credit card
    public function destroy($cardID)
    {
        $creditCard = CreditCard::findOrFail($cardID);
        $creditCard->delete();

        return response()->json(['message' => 'Credit card deleted successfully']);
    }
}

