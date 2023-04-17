<?php

namespace Database\Factories;

use App\Models\products;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class productsFactory extends Factory
{
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    { 
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(4),
            'price' => $this->faker->randomFloat(2, 10, 99),
            'color' => $this->faker->hexColor(),
            'height_cm' => $this->faker->randomNumber(3),
            'width_cm' => $this->faker->randomNumber(3),
            'depth_cm' => $this->faker->randomNumber(3),
            'weight_gr'=> $this->faker->randomNumber(4),
            'barcode' => $this->faker->ean8,
            
        ];
    }
}
