<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Products::all(); // Fetch all products
        return response()->json($products); // Return as JSON
    }

    /**
     * Display a single product by ID.
     */
    public function show($id)
    {
        // Find the product by ID
        $product = Products::find($id);

        // If the product is not found, return a 404 response
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Return the product as a JSON response
        return response()->json($product);
    }
}