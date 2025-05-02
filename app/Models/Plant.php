<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plant extends Model
{
    protected $fillable = ['name', 'price', 'description', 'stock'];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
