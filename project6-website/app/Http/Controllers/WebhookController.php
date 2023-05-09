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
        $token = '19|RxAmlMsGtp7zu1oCDmW3YKLuMm5hkn6DtjJLLLsQ';

        // Send an authenticated request to the API provider using the bearer token
        $response = Http::withToken($token)->get('http://kuin.summaict.nl/api/product');

        // Get the response body as an array of products
        $apiProducts = $response->json();

        // Loop through each product in the database and update it with new information from the API
        foreach ($apiProducts as $apiProduct) {
            $product = Product::where('id', $apiProduct['id'])->firstOrFail();
            $product->name = $apiProduct['name'];
            $product->description = $apiProduct['description'];
            $product->price = $apiProduct['price'];
            $product->image = $apiProduct['image'];
            $product->color = $apiProduct['color'];
            $product->height_cm = $apiProduct['height_cm'];
            $product->width_cm = $apiProduct['width_cm'];
            $product->depth_cm = $apiProduct['depth_cm'];
            $product->weight_gr = $apiProduct['weight_gr'];
            $product->created_at = $apiProduct['created_at'];
            $product->updated_at = $apiProduct['updated_at'];
            $product->save();
        }

        // Respond to the webhook with a success message
        return response()->json(['message' => 'Webhook handled successfully']);
    }
}
