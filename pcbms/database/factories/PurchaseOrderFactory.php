<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseOrder>
 */
class PurchaseOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     * @return array<string, mixed>
     */
    public function definition()
    {
        $suppliers = Supplier::pluck('id')->toArray();

        return [
            'purchase_order_code' => $this->faker->numberBetween(123, 899) . "ERW" . $this->faker->numberBetween(123, 899),
            'supplier_id' => $suppliers[array_rand($suppliers)],
            'total' => $this->faker->randomFloat(1, 1, 1000),
            'del_date' => $this->faker->dateTimeBetween('-10 week', '+3 week'),
        ];
    }
}
