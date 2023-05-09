<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

class UpdateDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-database-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches products from API and updates the database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get the products from the API
        $response = Http::get('http://kuin.summaict.nl/api/product');
        $apiProducts = $response->json();

        // Update the products in the database
        foreach ($apiProducts as $apiProduct) {
            $product = Product::where('id', $apiProduct['id'])->first();

            if ($product) {
                // If the product exists in the database, update its fields
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
            } else {
                // If the product does not exist in the database, create a new one
                Product::create($apiProduct);
            }
        }

        $this->info('Products updated successfully!');
    }
}
