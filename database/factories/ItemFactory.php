<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private static $counter = 1;

    public function definition()
    {

        return [
            'barcode' => $this->faker->ean8(),
            'product_name' => $this->faker->text(10),
            'category' => $this->faker->randomElement(['beverages','bread/bakery','canned/jarred goods','dairy','dry/baking goods','paper goods','personal care','snacks','other']),
            'expiration' => $this->faker->dateTimeBetween('-4 week', '+10 week'),
            'qty' => $this->faker->randomNumber(3, true),
            'purchase_unit_price' => $purchaseUnitPrice = $this->faker->randomFloat(1, 1, 150),
            'selling_unit_price' => $purchaseUnitPrice * $this->faker->randomFloat(1, 1, 3),
        ];
    }
}
