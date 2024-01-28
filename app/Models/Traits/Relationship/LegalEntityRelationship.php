<?php

namespace App\Models\Traits\Relationship;

use App\Models\Customer;
use App\Models\Income;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Trait LegalEntityRelationship
 * @package App\Models\Traits\Relationship
 */
trait LegalEntityRelationship
{
    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * @return HasMany
     */
    public function incomes(): HasMany
    {
        return $this->hasMany(Income::class);
    }
}
