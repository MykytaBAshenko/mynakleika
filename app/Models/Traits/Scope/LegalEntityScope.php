<?php

namespace App\Models\Traits\Scope;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait LegalEntityScope
 * @package App\Models\Traits\Scope
 */
trait LegalEntityScope
{
    /**
     * Scope a query to only verified payers
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('verification_status', self::VERIFICATION_STATUS_APPROVED);
    }
}
