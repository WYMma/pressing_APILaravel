<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    // Retrieve all items
    public function index()
    {
        return Item::with('category')->get();
    }

    // Add a new item
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'categorieID' => 'required|exists:categories,categorieID',
            'photo' => 'required|image|max:2048',
        ]);

        // Handle the file upload
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('images', $imageName, 'public'); // Store in public storage
            $imageUrl = Storage::url($path); // Generate the URL
        } else {
            $imageUrl = null; // or use a default image if desired
        }

        $item = Item::create([
            'name' => $request->name,
            'price' => $request->price,
            'categorieID' => $request->categorieID,
            'photo' => $imageUrl,
        ]);

        return response()->json($item, 201);
    }

    // Retrieve a single item
    public function show($id)
    {
        $item = Item::with('category')->findOrFail($id);
        return response()->json($item);
    }

    // Update an existing item
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'name' => 'string|max:255',
            'price' => 'numeric',
            'categorieID' => 'exists:categories,categorieID',
            'photo' => 'image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($item->photo) {
                Storage::delete($item->photo);
            }

            // Store new photo
            $path = $request->file('photo')->store('public/items');
            $item->photo = $path;
        }

        $item->update($request->only(['name', 'price', 'categorieID', 'photo']));

        return response()->json($item);
    }

    // Delete an item
    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        if ($item->photo) {
            Storage::delete($item->photo);
        }

        $item->delete();

        return response()->json(null, 204);
    }
}
