<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Products; // Ensure this matches your model name
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // Add a product to favorites
    public function addToFavorites(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = Auth::user(); // Get the authenticated user (Customer or Retailer)

        // Check if the product is already in favorites
        $existingFavorite = Favorite::where('user_id', $user->id)
            ->where('user_type', get_class($user)) // Store the user type (Customer or Retailer)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingFavorite) {
            return response()->json(['message' => 'Product is already in favorites'], 400);
        }

        // Add the product to favorites
        Favorite::create([
            'user_id' => $user->id,
            'user_type' => get_class($user), // Store the user type
            'product_id' => $request->product_id,
        ]);

        return response()->json(['message' => 'Product added to favorites'], 200);
    }

    // Remove a product from favorites
    public function removeFromFavorites($productId)
    {
        $user = Auth::user(); // Get the authenticated user (Customer or Retailer)

        // Validate that the product exists
        if (!Products::find($productId)) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Find and delete the favorite entry
        $favorite = Favorite::where('user_id', $user->id)
            ->where('user_type', get_class($user)) // Match the user type
            ->where('product_id', $productId)
            ->first();

        if (!$favorite) {
            return response()->json(['message' => 'Product not found in favorites'], 404);
        }

        $favorite->delete();

        return response()->json(['message' => 'Product removed from favorites'], 200);
    }

    // View all favorite products
    public function viewFavorites()
    {
        $user = Auth::user(); // Get the authenticated user (Customer or Retailer)

        // Get all favorite products for the user
        $favorites = Favorite::where('user_id', $user->id)
            ->where('user_type', get_class($user)) // Match the user type
            ->with('product') // Eager load the product details
            ->get();

        return response()->json(['favorites' => $favorites], 200);
    }
}