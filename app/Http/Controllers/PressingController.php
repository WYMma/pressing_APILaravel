<?php

namespace App\Http\Controllers;

use App\Models\Pressing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PressingController extends Controller
{
    public function index()
    {
        return response()->json(Pressing::all());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'written_address' => 'required|string|max:255',
            'google_map_address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/shops');
            $validatedData['image'] = $path;
        }

        $Pressing = Pressing::create($validatedData);

        return response()->json($Pressing, 201);
    }

    public function show($id)
    {
        $Pressing = Pressing::findOrFail($id);
        return response()->json($Pressing);
    }

    public function update(Request $request, $id)
    {
        $Pressing = Pressing::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'written_address' => 'sometimes|required|string|max:255',
            'google_map_address' => 'sometimes|required|string|max:255',
            'phone_number' => 'sometimes|required|string|max:15',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($Pressing->image) {
                Storage::delete($Pressing->image);
            }
            $path = $request->file('image')->store('public/shops');
            $validatedData['image'] = $path;
        }

        $Pressing->update($validatedData);

        return response()->json($Pressing);
    }

    public function destroy($id)
    {
        $Pressing = Pressing::findOrFail($id);

        if ($Pressing->image) {
            Storage::delete($Pressing->image);
        }

        $Pressing->delete();

        return response()->json(null, 204);
    }
}

