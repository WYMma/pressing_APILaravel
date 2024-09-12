<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    // Method to retrieve the ID and name of each category
    public function getCategoryIdAndName()
    {
        // Retrieve all categories with only ID and name
        $categories = Categorie::select('categorieID', 'name')->get();

        // Return the categories as a JSON response
        return response()->json($categories);
    }
}
