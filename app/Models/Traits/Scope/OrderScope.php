<?php

namespace App\Models\Traits\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

/**
 * Trait OrderScope
 * @package App\Models\Traits\Scope
 */
trait OrderScope
{
    /**
     * Scope a query to only unpaid orders
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeUnpaid(Builder $query): Builder
    {
        return $query->where('finance_status', self::NOT_PAID);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeUnpaidAndPartlyPaid(Builder $query): Builder
    {
        return $query->whereIn('finance_status', [self::NOT_PAID, self::PARTLY_PAID]);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeNotIncludedToBills(Builder $query): Builder
    {
        return $query->leftJoin('invoice_order', function(JoinClause $join) {
            $join->on('orders.id', '=', 'invoice_order.order_id');
        })->whereNull('invoice_order.order_id');
    }
}
