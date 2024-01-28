<?php

namespace App\Models\Traits\Relationship;

use App\Models\Income;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Trait TransactionRelationship
 * @package App\Models\Traits\Relationship
 */
trait TransactionRelationship
{
    /**
     * @return BelongsTo
     */
    public function income(): BelongsTo
    {
        return $this->belongsTo(Income::class);
    }

    /**
     * @return BelongsTo
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

}
