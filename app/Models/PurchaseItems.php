<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class PurchaseItems extends Model
{
    use HasFactory;
    protected $fillable = ['purchase_order_id', 'barcode', 'product_name', 'price', 'qty', 'total'];


    public function purchase_order(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
