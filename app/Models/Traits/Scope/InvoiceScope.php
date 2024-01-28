<?php

namespace App\Models\Traits\Scope;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait InvoiceScope
 * @package App\Models\Traits\Scope
 */
trait InvoiceScope
{

    /**
     * Scope a query by current date invoices
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('create_date', '=', Carbon::today()->toDateString());
    }

    /**
     * Scope a query to only unpaid invoices
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeUnpaid(Builder $query): Builder
    {
        return $query->whereIn('status', [self::STATUS_NOT_PAID, self::STATUS_PARTLY_PAID]);
    }
}
