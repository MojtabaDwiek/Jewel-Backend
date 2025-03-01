<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customers;
use App\Models\Retailer;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate as a customer
        $customer = Customers::where('username', $request->username)->first();
        if ($customer && $request->password === $customer->password) { // Compare plain text passwords
            $token = $customer->createToken('CustomerToken')->plainTextToken; // Create token for customer
            return response()->json([
                'message' => 'Customer login successful',
                'user' => $customer,
                'token' => $token,
                'customer_id' => $customer->id, // Include customer_id
                'retailer_id' => null, // No retailer_id for customers
            ]);
        }

        // Attempt to authenticate as a retailer
        $retailer = Retailer::where('username', $request->username)->first();
        if ($retailer && $request->password === $retailer->password) { // Compare plain text passwords
            $token = $retailer->createToken('RetailerToken')->plainTextToken; // Create token for retailer
            return response()->json([
                'message' => 'Retailer login successful',
                'user' => $retailer,
                'token' => $token,
                'retailer_id' => $retailer->id, // Include retailer_id
                'customer_id' => null, // No customer_id for retailers
            ]);
        }

        // If authentication fails
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        // Revoke the current user's token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}