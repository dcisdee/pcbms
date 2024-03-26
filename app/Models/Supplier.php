<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'company', 'phone', 'address'];

    public function purchase_order(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
