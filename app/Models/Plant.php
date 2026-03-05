<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle représentant une plante en vente.
 */
class Plant extends Model
{
    protected $fillable = ['name', 'price', 'description', 'stock'];

    /**
     * Relation : items de commande contenant cette plante.
     *
     * @return HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
