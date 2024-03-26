<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['total', 'cash', 'change', 'transaction_status'];


    public function personnel(): BelongsTo
    {
        return $this->belongsTo(Personnel::class);
    }

    public function sale_items(): HasMany
    {
        return $this->hasMany(SaleItems::class);
    }
}
