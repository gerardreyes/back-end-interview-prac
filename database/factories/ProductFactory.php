<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        // Generate a unique word as the product name
        $name = $this->faker->unique()->words(3, true);

        // Generate a random sentence as the product description
        $description = $this->faker->sentence(10);

        return [
            'name' => substr($name, 0, 64), // Limit to 64 characters
            'description' => substr($description, 0, 255), // Limit to 255 characters
        ];
    }
}
