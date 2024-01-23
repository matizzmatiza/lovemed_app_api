<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;

class CategoryController extends Controller
{
    public function indexCategories($eventId)
    {
        $categories = Category::where('event_id', $eventId)->get();
        return response()->json($categories);
    }

    public function storeCategory(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string',
            'event_id' => 'required|integer',
        ]);

        $category = Category::create($validatedData);

        return response()->json($category, 201);
    }

    public function destroyCategory($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return response()->json(['message' => 'Category deleted successfully']);
        } else {
            return response()->json(['message' => 'Category not found'], 404);
        }
    }

    public function indexCategoriesJuror($jurorId)
    {
        // get all categories for juror from pivot table
        $juror = User::find($jurorId);
        $categories = $juror->categories()->get();

        return response()->json($categories);
    }
}