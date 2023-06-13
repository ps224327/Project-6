<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Http;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Get the bearer token from your configuration or environment variables
        $token = getenv('API_KEY');

        // Send an authenticated request to the API provider using the bearer token
        $response = Http::withToken($token)->get('http://kuin.summaict.nl/api/product');

        // Get the response body as an array of products
        $apiProducts = $response->json();

        // Get the IDs of products from the API response
        $apiProductIds = collect($apiProducts)->pluck('id')->all();

        // Find the products in the database that are not present in the API response
        $productsToRemove = Product::whereNotIn('id', $apiProductIds)->get();

        // Remove the products from the database
        foreach ($productsToRemove as $product) {
            $product->delete();
        }

        // Iterate over the API products and update/create records in the database
        foreach ($apiProducts as $apiProduct) {
            $product = Product::updateOrCreate(['id' => $apiProduct['id']], $apiProduct);
        }

        // Respond to the webhook with a success message
        return response()->json(['message' => 'Webhook handled successfully']);
    }
}
