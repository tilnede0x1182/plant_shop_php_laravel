<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modèle représentant un item dans une commande.
 */
class OrderItem extends Model
{
    protected $fillable = ['order_id', 'plant_id', 'quantity'];

    /**
     * Relation : commande parente.
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relation : plante de l'item.
     *
     * @return BelongsTo
     */
    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }
}
