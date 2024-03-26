<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['barcode', 'product_name', 'category', 'expiration', 'qty', 'purchase_unit_price', 'selling_unit_price'];

    public function scopeSearch($query, $value){
        $query->where('barcode', "like", "%{$value}%")
              ->orWhere('product_name', 'like', "%{$value}%");
    }

    public function sale_items(): HasMany
    {
        return $this->hasMany(SaleItems::class);
    }
}
