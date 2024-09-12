<?php

namespace App\Http\Controllers;

use App\Models\LignePanier;
use App\Models\Panier;
use Illuminate\Http\Request;

class LignePanierController extends Controller
{
    // Method to create a new cart and return its ID
    public function createCart(Request $request)
    {
        $request->validate([
            'total_price' => 'required|numeric',
        ]);

        // Create a new cart with the total price
        $cart = Panier::create([
            'total_price' => $request->total_price,
        ]);

        // Return the cartID of the newly created cart
        return response()->json(['cartID' => $cart->cartID], 201);
    }

    // Method to store LignePanier items
    public function store(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer',
            'serviceID' => 'required|exists:services,serviceID',
            'cartID' => 'required|exists:paniers,cartID',
            'itemID' => 'nullable|exists:items,itemID',
            'initialPrice' => 'required|numeric',
            'productPrice' => 'required|numeric',
            'categorieID' => 'nullable|exists:categories,categorieID',
        ]);

        $lignePanier = LignePanier::create($request->all());

        return response()->json($lignePanier, 201);
    }

    // Method to retrieve all LignePanier items for a given cartID
    public function index($cartID)
    {
        $lignePaniers = LignePanier::where('cartID', $cartID)->get();
        return response()->json($lignePaniers);
    }
}
