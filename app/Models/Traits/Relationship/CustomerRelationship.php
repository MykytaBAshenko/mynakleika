<?php

namespace App\Models\Traits\Relationship;

use App\Models\Auth\User;
use App\Models\Delivery;
use App\Models\LegalEntity;
use App\Models\Manager;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Models\Invoice;

/**
 * Trait CustomerRelationship
 * @package App\Models\Traits\Relationship
 */
trait CustomerRelationship
{
    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return HasMany
     */
    public function legalEntities(): HasMany
    {
        return $this->hasMany(LegalEntity::class);
    }

    /**
     * @return BelongsToMany
     */
    public function deliveries(): BelongsToMany
    {
        return $this->belongsToMany(Delivery::class);
    }

    /**
     * @return mixed
     */
    public function invoices(): HasManyThrough
    {
        return $this->hasManyThrough(
            Invoice::class,
            LegalEntity::class,
            'customer_id', // Foreign key on LegalEntity table...
            'legal_entity_id', // Foreign key on Invoice table...
            'id', // Local key on Customer table...
            'id' // Local key on LegalEntity table...
        );
    }

    /**
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
