<?php

namespace Database\Seeders;

use App\Models\PurchaseItems;
use App\Models\PurchaseDelivery;
use App\Models\PurchaseOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PurchaseOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $purchase_orders = PurchaseOrder::factory()->count(20)->create();

        foreach ($purchase_orders as $purchase_order) {
            PurchaseItems::create([
                'purchase_order_id' => $purchase_order->id,
                'barcode' => $faker->ean8(),
                'product_name' => $faker->text(10),
                'price' => $purchaseUnitPrice = $faker->randomFloat(1, 1, 150),
                'qty' => $qty = $faker->randomNumber(3, true),
                'total' => $purchaseUnitPrice * $qty
            ]);

            PurchaseDelivery::create([
                'purchase_order_id' => $purchase_order->id,
                'purchase_status' =>  $faker->randomElement(['In Transit','Delivered','Return to Sender','Cancelled']),
            ]);
        };
    }
}
