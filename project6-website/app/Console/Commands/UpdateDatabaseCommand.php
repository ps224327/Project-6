<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Http;

class UpdateDatabaseCommand extends Command
{
    protected $signature = 'app:update-database-command';
    protected $description = 'Update the database with product data from the API';

    public function handle()
    {
        $apiUrl = 'http://kuin.summaict.nl/api/product';
        $token = getenv('API_KEY');

        $apiResponse = Http::withToken($token)->get($apiUrl);

        if ($apiResponse->successful()) {
            $apiProducts = $apiResponse->json();

            if (!empty($apiProducts)) {
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

                $this->info('Products updated successfully.');
            } else {
                $this->error('Empty API response or invalid product data.');
            }
        } else {
            $this->error('Failed to fetch product data from the API.');
        }
    }
}
