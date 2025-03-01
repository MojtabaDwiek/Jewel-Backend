<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function getRetailerPhoneNumber(Customers $customer)
    {
        // Check if the customer has a retailer
        if (!$customer->retailer) {
            return response()->json([
                'success' => false,
                'message' => 'Retailer not found for this customer.',
            ], 404);
        }

        // Return the retailer's phone number
        return response()->json([
            'success' => true,
            'data' => [
                'retailer_phone_number' => $customer->retailer->phone,
            ],
        ]);
    }

    public function getCustomerId(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        // Find the customer record associated with the user
        $customer = Customer::where('email', $user->email)->first();

        // Ensure the customer exists
        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found for this user.',
            ], 404);
        }

        // Return the customer ID
        return response()->json([
            'success' => true,
            'data' => [
                'customer_id' => $customer->id, // Return the customer ID
            ],
        ]);
    }
}