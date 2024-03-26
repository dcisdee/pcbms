<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Personnel extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'first_name', 'mid_initial', 'last_name', 'sex', 'email', 'phone', 'address', 'is_admin'];

    public function User(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function Log(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function getFullname()
    {
        return $this->first_name . ' ' . $this->mid_initial . ' ' . $this->last_name;
    }

    public function getPosition()
    {
        return $this->is_admin ? "manager" : "sales";
    }
}
