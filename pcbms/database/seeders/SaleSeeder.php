<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Sale;
use App\Models\SaleItems;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($j = 1; $j <= 10; $j++) {
            // Generate random number of items for each sale
            $number_of_items = $faker->numberBetween(1, 8);
            $items = [];
            $grandTotal = 0;

            // Populate items array with random items
            for ($i = 0; $i < $number_of_items; $i++) {
                $num = $faker->numberBetween(1, 30);
                $item = Item::find($num);

                if ($item) {
                    $items[] = $item;
                    $grandTotal += ($item->selling_unit_price * $number_of_items);
                }
            }

            // Calculate cash and change for the sale
            $cash = $grandTotal + $faker->numberBetween(10, 100);
            $change = $cash - $grandTotal;

            // Create a new sale
            $sale = Sale::create([
                'id' => $faker->ean8(),
                'total' => $grandTotal,
                'cash' => $grandTotal == 0 ? 0 : $cash,
                'change' => $grandTotal == 0 ? 0 : $change,
                'transaction_status' => $grandTotal == 0 ? 'cancelled' : 'successful',
                'created_at' => $faker->dateTimeBetween('-8 week', '-1 day')
            ]);

            // Associate items with the sale
            if ($sale) {
                foreach ($items as $item) {
                    SaleItems::create([
                        'item_id' => $item->id,
                        'sale_id' => $sale->id,
                        'price' => $item->selling_unit_price,
                        'quantity' => $faker->numberBetween(1, 5),
                        'total' => $grandTotal,
                    ]);
                }
            }
        }
    }
}
