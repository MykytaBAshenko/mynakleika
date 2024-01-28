<?php

namespace App\Models\Traits\Method;


/**
 * Trait InvoiceMethod
 * @package App\Models\Traits\Method
 */
trait InvoiceMethod
{
    /**
     * @return int
     */
    public static function getCountOfInvoicesForToday(): int
    {
        return self::today()->get()->count();
    }

    /**
     * @return int
     */
    public function getPayedSum(): int
    {
        return $this->incomes()->sum('value');
    }
}
