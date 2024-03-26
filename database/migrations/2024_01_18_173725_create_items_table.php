<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->integer('barcode');
            $table->string('product_name');
            $table->enum('category', ['beverages', 'bread/bakery', 'canned/jarred goods', 'dairy', 'dry/baking goods', 'paper goods', 'personal care', 'snacks', 'other']);
            $table->date('expiration');
            $table->integer('qty');
            $table->decimal('purchase_unit_price', $precision = 8, $scale = 2);
            $table->decimal('selling_unit_price', $precision = 8, $scale = 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
