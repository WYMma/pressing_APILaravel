<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    // Retrieve all services
    public function index()
    {
        $services = Service::all();
        return response()->json($services);
    }

    // Add a new service
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|mimes:jpg,jpeg,png,svg|max:2048', // Adjust validation rules as needed
        ]);

        // Handle the file upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('images', $imageName, 'public'); // Store in public storage
            $imageUrl = Storage::url($path); // Generate the URL
        } else {
            $imageUrl = null; // or use a default image if desired
        }

        // Create a new service
        $service = Service::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'image' => $imageUrl, // Store the URL in the database
        ]);

        return response()->json($service, 201);
    }

    // Edit an existing service
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'file|mimes:jpg,jpeg,png,svg|max:2048', // Accept SVG files
        ]);

        $service = Service::findOrFail($id);
        $service->name = $validatedData['name'];
        $service->description = $validatedData['description'];
        $service->price = $validatedData['price'];

        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($service->image) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $service->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('images', $imageName, 'public'); // Store in public storage
            $imageUrl = Storage::url($path); // Generate the URL
            $service->image = $imageUrl; // Update the image URL in the database
        }

        $service->save();

        return response()->json($service);
    }

    // Delete a service
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json(['message' => 'Service deleted successfully']);
    }
}
