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
        $apiResponse = Http::get($apiUrl);

        if ($apiResponse->successful()) {
            $apiProduct = $apiResponse->json();

            if (!empty($apiProduct)) {
                $product = Product::where('id', $apiProduct['id'])->first();
                if ($product) {
                    $product->name = $apiProduct['name'];
                    $product->description = $apiProduct['description'];
                    $product->price = $apiProduct['price'];
                    $product->image = $apiProduct['image'];
                    $product->color = $apiProduct['color'];
                    $product->height_cm = $apiProduct['height_cm'];
                    $product->width_cm = $apiProduct['width_cm'];
                    $product->depth_cm = $apiProduct['depth_cm'];
                    $product->weight_gr = $apiProduct['weight_gr'];
                    $product->save();

                    $this->info('Product updated successfully.');
                } else {
                    $this->error('Product not found in the database.');
                }
            } else {
                $this->error('Empty API response or invalid product data.');
            }
        } else {
            $this->error('Failed to fetch product data from the API.');
        }
    }
}
