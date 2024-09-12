<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SaleController extends Controller
{
    // Retrieve all sales
    public function index()
    {
        $sales = Sale::all();
        return response()->json($sales);
    }

    // Add a new sale
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'serviceID' => 'required|exists:services,serviceID',
            'image' => 'nullable|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        // Handle the file upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('images', $imageName, 'public');
            $imageUrl = Storage::url($path);
        } else {
            $imageUrl = null;
        }

        // Create a new sale
        $sale = Sale::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'discount' => $validated['discount'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'image' => $imageUrl,
            'serviceID' => $validated['serviceID'],
        ]);

        // Retrieve all users with the role 'client'
        $clients = User::where('role', 'Client')->get();

        // Send FCM notification to each client
        foreach ($clients as $client) {
            $this->sendSaleNotification($client->id, $sale->name, $sale->description);
        }

        return response()->json($sale, 201);
    }

    // Method to send FCM notification
    private function sendSaleNotification($userID, $title, $body)
    {
        $fcmController = new FcmController();
        $fcmController->sendFcmNotification(new Request([
            'userID' => $userID,
            'title' => $title,
            'body' => $body
        ]));
    }

    // Edit an existing sale
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'serviceID' => 'required|exists:services,serviceID',
            'image' => 'file|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        $sale = Sale::findOrFail($id);
        $sale->fill($validatedData);

        if ($request->hasFile('image')) {
            if ($sale->image) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $sale->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('images', $imageName, 'public');
            $imageUrl = Storage::url($path);
            $sale->image = $imageUrl;
        }

        $sale->save();

        return response()->json($sale);
    }

    // Delete a sale
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();

        return response()->json(['message' => 'Sale deleted successfully']);
    }
}

