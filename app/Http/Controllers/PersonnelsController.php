<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PersonnelsController extends Controller
{
    public function getPersonnelByUserId($userId)
    {
        $personnel = Personnel::where('userID', $userId)->first();

        if (!$personnel) {
            return response()->json(['error' => 'Personnel not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($personnel);
    }

    public function updatePersonnel(Request $request, $personnelID) {
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'cin' => 'required|string',
            'email' => 'string',
        ]);

        $personnel = Personnel::findOrFail($personnelID);

        $personnel->update($validatedData);

        return response()->json($personnel);
    }
}
