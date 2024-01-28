<?php

namespace App\Models\Traits\Attribute;

use Carbon\Carbon;

/**
 * Trait InvoiceAttribute
 * @package App\Models\Traits\Attribute
 */
trait InvoiceAttribute
{
    /**
     * @param $date
     * @return mixed
     */
    public function getCreateDateAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->copy()->format('d.m.y');
    }

    /**
     * @param $date
     * @return mixed
     */
    public function getPaymentDateAttribute($date)
    {
        if ($date) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $date)->copy()->format('d.m.y');
        }

        return null;
    }

    public function getPaymentsAttribute(): array
    {
        $payed = $this->getPayedSum();
        $left = $this->sum - $payed;
        return [
            'payed' => $payed,
            'left'  => $left
        ];
    }
}
