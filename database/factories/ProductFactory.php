<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $productNames = [
            'Coke',
            'Pepsi',
            'Water',
            'Sprite',
            'Fanta',
            'Mountain Dew',
            'Dr Pepper',
            'Gatorade',
            'Red Bull',
            'Monster',
            '7 Up',
            'Lipton Iced Tea',
            'Vitamin Water',
            'Snapple',
            'Arizona Tea',
            'Minute Maid',
            'Tropicana',
            'Nestea',
            'Powerade',
            'Brisk'
        ];

        return [
            'name' => array_shift($productNames),
            'price' => $this->faker->randomFloat(2, 0.5, 10), // Prices between 0.5 and 10
            'quantity_available' => $this->faker->numberBetween(1, 100),
        ];
    }
}
