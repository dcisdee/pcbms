<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $fillable = ['purchase_order_code', 'supplier_id', 'total', 'del_date'];

    public function personnel(): BelongsTo
    {
        return $this->belongsTo(Personnel::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchase_items(): HasMany
    {
        return $this->hasMany(PurchaseItems::class);
    }

    public function purchase_delivery(): HasOne
    {
        return $this->hasOne(PurchaseDelivery::class);
    }
}
