<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Client;
use App\Models\Panier;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'clientID' => 'required|exists:clients,clientID',
            'addressID' => 'required|exists:addresses,addressID',
            'pickUpDate' => 'required|date',
            'deliveryDate' => 'required|date',
            'paymentMethod' => 'required|string',
            'deliveryType' => 'required|string',
            'confirmationTimestamp' => 'required|date',
            'status' => 'required|string',
            'cartID' => 'required|exists:paniers,cartID',
            'totalPrice' => 'required|numeric',
            'isConfirmed' => 'required|boolean',
            'isPickedUp' => 'required|boolean',
            'isInProgress' => 'required|boolean',
            'isShipped' => 'required|boolean',
            'isDelivered' => 'required|boolean',
        ]);

        // Create a new Commande record
        $commande = Commande::create($request->all());

        // Retrieve the client based on the clientID from the request
        $client = Client::where('clientID', $request->clientID)->first();

        if ($client) {
            // Send FCM notification to client
            $this->sendCommandeNotification($client->userID, 'Commande Confirmée', 'Votre commande a été confirmée 🥰🥰');
        } else {
            // Handle the case where the client is not found
            return response()->json(['error' => 'Client not found'], 404);
        }

        return response()->json($commande, 201);
    }
    private function sendCommandeNotification($userID, $title, $body)
    {
        // Ensure that the FcmController is properly included
        $fcmController = app(FcmController::class);
        $fcmController->sendFcmNotification(new Request([
            'userID' => $userID,
            'title' => $title,
            'body' => $body
        ]));
    }

    public function index()
    {
        $commandes = Commande::all();

        return response()->json($commandes);
    }

    public function show($commandeID)
    {
        $commande = Commande::find($commandeID);

        if (!$commande) {
            return response()->json(['message' => 'Commande not found'], 404);
        }

        return response()->json($commande);
    }
    public function destroy($commandeID)
    {
        $commande = Commande::findOrFail($commandeID);
        $cart = Panier::findOrFail($commande->cartID);
        $cart->delete();

        return response()->json(['message' => 'Commande deleted successfully'], 200);
    }

    public function update(Request $request, $commandeID)
    {
        $request->validate([
            'clientID' => 'exists:clients,clientID',
            'addressID' => 'exists:addresses,addressID',
            'pickUpDate' => 'date',
            'deliveryDate' => 'date',
            'paymentMethod' => 'string',
            'deliveryType' => 'string',
            'confirmationTimestamp' => 'date',
            'status' => 'string',
            'cartID' => 'exists:paniers,cartID',
            'totalPrice' => 'numeric',
            'isConfirmed' => 'boolean',
            'isPickedUp' => 'boolean',
            'isInProgress' => 'boolean',
            'isShipped' => 'boolean',
            'isDelivered' => 'boolean',
        ]);

        $commande = Commande::findOrFail($commandeID);
        $commande->update($request->all());

        return response()->json($commande, 200);
    }
    public function pickup($commandeID)
    {
        $commande = Commande::findOrFail($commandeID);

        $commande->update([
            'isPickedUp' => true,
            'status' => 'Ramassée',
        ]);

        $client = Client::where('clientID', $commande->clientID)->first();

        if ($client) {
            $this->sendCommandeNotification($client->userID, 'Commande Ramassée', 'Votre commande a été ramassée 🥰🥰');
        } else {
            return response()->json(['error' => 'Client not found'], 404);
        }

        return response()->json($commande, 200);
    }
    public function deliver($commandeID)
    {
        $commande = Commande::findOrFail($commandeID);

        $commande->update([
            'isDelivered' => true,
            'status' => 'Livrée',
        ]);

        $client = Client::where('clientID', $commande->clientID)->first();

        if ($client) {
            $this->sendCommandeNotification($client->userID, 'Commande Livrée', 'Votre commande a été livrée 🥰🥰');
        } else {
            return response()->json(['error' => 'Client not found'], 404);
        }

        return response()->json($commande, 200);
    }
}
