<?php

namespace App\Models\Traits\Relationship;

use App\Models\Income;
use App\Models\LegalEntity;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class InvoiceRelationship
 * @package App\Models\Traits\Relationship
 */
trait InvoiceRelationship
{
    /**
     * @return BelongsTo
     */
    public function legalEntity(): BelongsTo
    {
        return $this->belongsTo(LegalEntity::class);
    }

    /**
     * @return BelongsToMany
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    /**
     * @return HasMany
     */
    public function incomes(): HasMany
    {
        return $this->hasMany(Income::class);
    }
}
