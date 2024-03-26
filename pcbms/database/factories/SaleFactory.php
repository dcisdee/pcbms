<?php
// database/factories/SaleFactory.php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\Item;
use App\Models\SaleItems;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition()
    {
        $faker = \Faker\Factory::create();

        $number_of_items = $faker->numberBetween(1, 10);
        $items = [];
        $grandTotal = 0;

        for ($i = 0; $i < $number_of_items; $i++) {
            $num = $faker->numberBetween(1, 30);
            $item = Item::find($num);
            if ($item) {
                $items[$i] = $item;
                $grandTotal += ($item->price * $item->qty);
            }
        }

        $cash = $grandTotal + 50;
        $change = $cash - $grandTotal;

        return [
            'total' => $grandTotal,
            'cash' => $cash,
            'change' => $change,
            'transaction_status' => 'successful',
            'items' => $items,
        ];
    }
}
