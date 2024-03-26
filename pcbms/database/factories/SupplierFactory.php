<?php

namespace Database\Factories;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
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
            'id' => 312300 . self::$counter++,
            'company' => $this->faker->company(),
            'phone' => '09' . $this->faker->randomNumber(9, true),
            'address' => $this->faker->streetAddress(),
        ];
    }
}
